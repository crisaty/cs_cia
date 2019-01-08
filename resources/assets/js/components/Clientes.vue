<template id="clientes">

  <div id="main-div">

        <v-layout row class=" px-4 pt-2 app--page-header">
          <div class="headline">
            <v-icon medium color="blue">
              people
            </v-icon>
              Listado de Clientes
          </div>
        </v-layout>

        <v-container grid-list-md fluid>
    
          <v-toolbar flat color="grey lighten-3" class="elevation-1">

            <v-btn color="success" @click="abrirModal('cliente','registrar')">
                Nuevo Cliente
            </v-btn>

            <v-spacer></v-spacer>
            <v-text-field
              v-model="buscar"
              append-icon="search"
              label="Busqueda"
              single-line
            ></v-text-field>

          </v-toolbar>

        <v-data-table 
            :headers="headers"
            :items="arrayCliente"
            :pagination.sync="pagination"
            :loading="loading"
            :search="buscar"
            class="elevation-1">
            <template slot="items" slot-scope="props">
                <td>{{ props.item.empresa }}</td>
                <td>{{ props.item.nom_cliente }}</td>
                <td>{{ formatDateM(props.item.fec_ingreso) }}</td>
                <td>{{ props.item.mail }}</td>
                <td>
                  <div v-if="props.item.telefono==null">
                    <v-chip small outline>- sin asignar -</v-chip>
                  </div>
                  <div v-else>
                    <v-tooltip left>
                      <v-chip slot="activator" small outline color="teal" @click="ApiWhatsApp(props.item.telefono, props.item.nom_cliente)">
                        {{ props.item.telefono }}
                      </v-chip>
                      <span>Enviar Mensaje en WhatsApp</span>
                    </v-tooltip>
                  </div>
                </td>
                <td>
                  <div v-if="props.item.estado">
                    <v-chip small outline color="green">Activa</v-chip>
                  </div>
                  <div v-else>
                    <v-chip small outline color="red">Desactivada</v-chip>
                  </div>
                </td>
                <td v-text="formatDateTime(props.item.updated_at)"></td>
                <td>
                  <v-flex d-inline-flex>
                    <v-btn flat small round  color="primary" @click="abrirModal('cliente','editar', props.item)">
                      Editar
                    </v-btn>
                    <template v-if="props.item.estado==1">
                      <v-btn flat small round color="warning darken-2" @click="desactivarCliente(props.item.id_cliente)" >
                          Desactivar
                      </v-btn>
                    </template>
                    <template v-else>
                      <v-btn flat small round color="success" @click="activarCliente(props.item.id_cliente)" >
                          Activar
                      </v-btn>
                    </template>
                    <v-btn flat small icon color="error darken-2" @click="eliminarCliente(props.item.id_cliente)" >
                      <v-icon>cancel</v-icon>
                    </v-btn>
                  </v-flex>
                </td>
              </template>
            
              <v-alert outline slot="no-results" transition="slide-y-reverse-transition" color="grey darken-1" :value="true" icon="info">
                La busqueda para "{{ buscar }}" no encuentra registros asociados.
              </v-alert>
              
        </v-data-table>

        <!-- MODAL -->
        <v-dialog v-model="dialog" persistent max-width="400px" max-height="400px" ref="modalClientes" @hidden="cerrarModal">
          <v-card>
            <v-card-title
              class="headline grey lighten-3">{{ tituloModal }}
            </v-card-title>

            <v-form ref="formCliente" v-model="valid" lazy-validation>

              <v-container grid-list-md>
              <v-layout wrap>

                <v-flex sm12>
                  <v-select
                    v-model="idEmpresa"
                    :items="arrayEmpresa"
                    item-text="nom_empresa"
                    item-value="id_empresa"
                    :rules="[validar.required]"
                    label="Empresa"
                    required placeholder="Seleccionar"
                  ></v-select>
                </v-flex>
                <v-flex sm12>
                  <v-text-field 
                    :rules="[validar.required, validar.counter]"
                    counter maxlength="40"
                    label="Nombre Cliente" type="text" 
                    v-model="nombre" ref="nombre"
                    placeholder="Nombre Apellidos"
                  ></v-text-field>
                </v-flex>
                <v-flex sm6>
                  <v-dialog
                    ref="dialog" v-model="datepicker"
                     full-width width="290px">
                    <v-text-field
                      slot="activator"
                      label="Fecha Ingreso"
                      readonly :value="formatDate"
                      placeholder="Seleccionar"
                    ></v-text-field>
                    <v-date-picker v-model="fechaIngreso" scrollable locale="es" 
                      first-day-of-week="1" @input="$refs.dialog.save(fechaIngreso)">
                    </v-date-picker>
                  </v-dialog>
                </v-flex>
                <v-flex sm6>
                  <v-text-field 
                    label="Telefono (Opcional)" 
                    type="text" v-model="telefono"
                    return-masked-value
                    placeholder="(56) 9 XXXX XXXX"
                    mask="(56) 9 #### ####"
                  ></v-text-field>
                </v-flex>
                <v-flex sm12>
                  <v-text-field 
                        :rules="[validar.required, validar.email]"
                        label="Email" type="text" 
                        v-model="mail" ref="nombre"
                        placeholder="user@email.com"
                  ></v-text-field>
                </v-flex>

              </v-layout>
            </v-container>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn flat @click="cerrarModal()" >Cancelar</v-btn>
              <v-btn :disabled="!valid" color="success" flat @click="registrarCliente()" v-if="tipoAccion==1" >Registrar</v-btn>
              <v-btn :disabled="!valid" color="info" flat @click="editarCliente()" v-if="tipoAccion==2" >Actualizar</v-btn>
            </v-card-actions>

            </v-form>

          </v-card>
        </v-dialog>

        <v-snackbar
          v-model="snackbar"
          :top="true"
          :multi-line="true"
          :timeout="3000"
        >
          {{ snackbar_text }}
          <v-btn color="pink" flat @click="snackbar = false">Cerrar</v-btn>
        </v-snackbar>

      </v-container>

  </div>

</template>

<script>

var moment = require('moment');

    export default {
        data() {
            return {
              // DATA MODELO
              id: 0,
              idEmpresa: 0,
              arrayEmpresa : [],
              nombre: '',
              fechaIngreso: '',
              mail: '',
              telefono: '',
              arrayCliente : [],
              // MODAL DIALOG
              dialog: false,
              tituloModal: '',
              tipoAccion: 0,
              // DATATABLE
              headers: [
                { text: 'Empresa', value: 'empresa' },
                { text: 'Nombre', value: 'nom_cliente' },
                { text: 'Fecha Ingreso', value: 'fec_ingreso' },
                { text: 'Mail', value: 'mail' },
                { text: 'Telefono', value: 'telefono' },
                { text: 'Estado', value: 'estado' },
                { text: 'Actualizacion', value: 'updated_at' },
                { text: 'Acciones / Opciones', align: 'center', sortable: false }
              ],
              pagination: {
                rowsPerPage: 10
              },
              buscar: '',
              // VALIDACIONES
              valid: false,
              validar: {
                required: val => !!val || 'Campo Requerido.',
                counter: val => (val && val.length <= 40) || 'Maximo 40 Caracteres.',
                email: val => /.+@.+/.test(val) || 'Ingrese un Mail Valido.'
              },
              // NOTIFICACIONES
              snackbar: false,
              snackbar_text: '',
               // OTROS
              loading: true,
              menuExportar: [
                { title: 'Click Me' },
                { title: 'Click Me' }
              ],
              datepicker: false
            }
        },
        methods : {
          listarClientes() {
            let me = this;
            var url = '/cliente';

            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayCliente = respuesta.clientes;
                me.loading = false;
              })
              .catch(function (error) {
                // handle error
                me.loading = false;
                console.log(error);
              });
          },
          selectEmpresa() {
            let me = this;
            var url = '/cliente/selectEmpresa';

            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayEmpresa = respuesta.empresas;
              })
              .catch(function (error) {
                // handle error
                console.log(error);
              });
          },
          registrarCliente () {
            if (this.$refs.formCliente.validate()) {

              let me = this;

              axios.post('/cliente/registrar', {
                'idEmpresa': this.idEmpresa,
                'nombre': this.nombre,
                'fechaIngreso': this.fechaIngreso,
                'mail': this.mail,
                'telefono': this.telefono
              }).then(function (response) {
                  me.cerrarModal();
                  me.listarClientes('');
                  me.snackbar_text = 'Cliente Registrado Exitosamente'
                  me.snackbar = true;
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                });
            }
          },
          editarCliente () {
            if (this.$refs.formCliente.validate()) {

              let me = this;

              axios.put('/cliente/actualizar', {
                'id': this.id,
                'idEmpresa': this.idEmpresa,
                'nombre': this.nombre,
                'fechaIngreso': this.fechaIngreso,
                'mail': this.mail,
                'telefono': this.telefono
              }).then(function (response) {
                  me.cerrarModal();
                  me.listarClientes('');
                  me.snackbar_text = 'Cliente Actualizado Exitosamente'
                  me.snackbar = true;
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                });
            }
          },
          abrirModal(modelo, accion, data = []) {
            this.dialog = true;

            switch (modelo) {
              case "cliente":
              {
                switch (accion) {
                  case 'registrar':
                  {
                    this.$refs.formCliente.reset();
                    this.tituloModal = 'Nuevo Cliente';
                    this.fechaIngreso = new Date().toISOString().substr(0, 10);
                    this.telefono = '';
                    this.tipoAccion = 1;
                    break;
                  }
                  case 'editar':
                  {
                    //console.log(data);
                    this.tituloModal = 'Editar Cliente';
                    this.id = data['id_cliente'];
                    this.nombre = data['nom_cliente'];
                    this.idEmpresa = data['empresa_id_empresa'];
                    this.fechaIngreso = data['fec_ingreso'];
                    this.mail = data['mail'];
                    this.telefono = data['telefono'];
                    this.tipoAccion = 2;
                    break;
                  }
                }
              }
            }
            this.selectEmpresa();
          },
          cerrarModal () {
            this.idEmpresa = 0,
            this.nombre = '',
            this.fechaIngreso = '',
            this.telefono = '',
            this.mail = '',
            this.dialog = false
          },
          desactivarCliente(id) {
              let me = this;

              axios.put('/cliente/desactivar', {
                'id': id
              }).then(function (response) {
                  me.listarClientes('');
                  // SWEET ALERT
                  swal({
                    type: 'error',
                    title: 'Cliente Desactivado',
                    showConfirmButton: false,
                    timer: 1500
                  })
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                });
            },
            activarCliente(id) {
                let me = this;

                axios.put('/cliente/activar', {
                  'id': id
                }).then(function (response) {
                    me.listarClientes('');
                    // SWEET ALERT
                    swal({
                      type: 'success',
                      title: 'Cliente Activado',
                      showConfirmButton: false,
                      timer: 1500
                    })
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  });
              },
              eliminarCliente(id) {
                  let me = this;

                      // SWEET ALERT
                      swal({
                        type: 'warning',
                        title: '¿Desea eliminar definitivamente este cliente?',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Confirmar',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancelar'
                      }).then((result) => {
                          if (result.value) {
                            swal(
                              '¡Exito!',
                              'El cliente ha sido eliminado',
                              'success'
                            )
                            axios.put('/cliente/delete', {
                              'id': id
                            }).then(function (response) {
                                me.listarClientes('');
                              })
                          }
                        })

                    .catch(function (error) {
                      // handle error
                      console.log(error);
                    });
                },
              formatDateM(date) {
                return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
              },
              formatDateTime(date) {
                return moment.utc(date, 'YYYY-MM-DD HH:mm').format('HH:mm | DD/MM/YYYY');
              },
              ApiWhatsApp(telefono, nombre) {

                let number = telefono.replace(/\D+/g, '');
                let message = 'Hola, '+nombre;

                window.open(
                  "https://wa.me/"+number+"?text="+message,
                  '_blank'
                );
              }
        },
        mounted() {
            console.log('Componente List Clientes Cargado');
            // Invocar metodo index
            this.listarClientes('');
        },
        created() {
          //do something after creating vue instance
            this.loading = true;
        },
        computed: {
          formatDate() {
            return this.fechaIngreso ? moment(this.fechaIngreso).format('DD/MM/YYYY') : ''
          }
        }
    }

</script>
