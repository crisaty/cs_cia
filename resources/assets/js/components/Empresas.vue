<template id="empresas">

  <div id="main-div">

        <v-layout row class=" px-4 pt-2 app--page-header">
          <div class="headline">
            <v-icon medium color="blue">
              domain
            </v-icon>
              Listado de Empresas
          </div>
        </v-layout>

        <v-container grid-list-md fluid>
    
          <v-toolbar flat color="grey lighten-3" class="elevation-1">

            <v-btn color="success" @click="abrirModal('empresa','registrar')">
                Nueva Empresa
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
            :items="arrayEmpresa"
            :pagination.sync="pagination"
            :loading="loading"
            :search="buscar"
            class="elevation-1">
            <template slot="items" slot-scope="props">
                <td>{{ props.item.nom_empresa }}</td>
                <td>{{ props.item.rep_empresa }}</td>
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
                    <v-btn flat small round  color="primary" @click="abrirModal('empresa','editar', props.item)">
                      Editar
                    </v-btn>
                    <template v-if="props.item.estado==1">
                      <v-btn flat small round color="warning darken-2" @click="desactivarEmpresa(props.item.id_empresa)" >
                          Desactivar
                      </v-btn>
                    </template>
                    <template v-else>
                      <v-btn flat small round color="success" @click="activarEmpresa(props.item.id_empresa)" >
                          Activar
                      </v-btn>
                    </template>
                    <v-btn flat small icon  color="error darken-2" @click="eliminarEmpresa(props.item.id_empresa)" >
                      <v-icon>cancel</v-icon>
                    </v-btn>
                  </v-flex>
                </td>
            </template>

            <v-alert outline slot="no-results" transition="slide-y-reverse-transition" color="grey darken-1" :value="true" icon="info">
                La busqueda para "{{ buscar }}" no encuentra registros asociados.
            </v-alert>
              
          </v-data-table>

        <v-dialog v-model="dialog" persistent max-width="400px" max-height="400px" ref="modalEmpresas" @hidden="cerrarModal">
          <v-card>
            <v-card-title
              class="headline grey lighten-3">{{ tituloModal }}
            </v-card-title>

            <v-form ref="formEmpresa" v-model="valid" lazy-validation>

              <v-container grid-list-md>
              <v-layout wrap>
                <v-flex sm12>
                  <v-text-field 
                    :rules="[validar.required, validar.counter]"
                    counter maxlength="40"
                    label="Nombre Empresa" type="text" 
                    v-model="nombre" ref="nombre"
                    placeholder="Empresa X"
                  ></v-text-field>
                </v-flex>
                <v-flex sm12>
                  <v-text-field 
                    :rules="[validar.required, validar.counter]"
                    counter maxlength="40"
                    label="Representante" 
                    type="text" v-model="representante" 
                    placeholder="Nombre Apellidos"
                  ></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn flat @click="cerrarModal()" >Cancelar</v-btn>
              <v-btn :disabled="!valid" color="success" flat @click="registrarEmpresa()" v-if="tipoAccion==1" >Registrar</v-btn>
              <v-btn :disabled="!valid" color="info" flat @click="editarEmpresa()" v-if="tipoAccion==2" >Actualizar</v-btn>
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

import VueElementLoading from 'vue-element-loading';

var moment = require('moment');

    export default {
        data() {
            return {
              // DATA MODELO
              id: 0,
              nombre: '',
              representante: '',
              arrayEmpresa : [],
              // MODAL DIALOG
              dialog: false,
              tituloModal: '',
              tipoAccion: 0,
              // DATATABLE
              headers: [
                { text: 'Nombre', value: 'nom_empresa' },
                { text: 'Representante', value: 'rep_empresa' },
                { text: 'Estado', value: 'estado' },
                { text: 'Actualización', value: 'updated_at' },
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
                counter: val => (val && val.length <= 40) || 'Maximo 40 Caracteres.'
              },
              // NOTIFICACIONES
              snackbar: false,
              snackbar_text: '',
               // OTROS
              loading: true,
              menuExportar: [
                { title: 'Click Me' },
                { title: 'Click Me' }
              ]
            }
        },
        watch: {
          dialog (val) {
            val || this.cerrarModal()
          }
        },
        methods : {
          listarEmpresas() {
            let me = this;
            var url = '/empresa';

            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayEmpresa = respuesta.empresas;
                me.loading = false;
              })
              .catch(function (error) {
                // handle error
                me.loading = false;
                console.log(error);
              });
          },
          registrarEmpresa () {
            if (this.$refs.formEmpresa.validate()) {

              let me = this;

              axios.post('/empresa/registrar', {
                'nombre': this.nombre,
                'representante': this.representante,
              }).then(function (response) {
                  me.cerrarModal();
                  me.listarEmpresas();
                  me.snackbar_text = 'Empresa Registrada Exitosamente'
                  me.snackbar = true;
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                });
            }
          },
          editarEmpresa () {
            if (this.$refs.formEmpresa.validate()) {

              let me = this;

              axios.put('/empresa/actualizar', {
                'id': this.id,
                'nombre': this.nombre,
                'representante': this.representante,
              }).then(function (response) {
                  me.cerrarModal();
                  me.listarEmpresas();
                  me.snackbar_text = 'Empresa Actualizada Exitosamente'
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
              case "empresa":
              {
                switch (accion) {
                  case 'registrar':
                  {
                    this.tituloModal = 'Nueva Empresa';
                    this.tipoAccion = 1;
                    break;
                  }
                  case 'editar':
                  {
                    //console.log(data);
                    this.tituloModal = 'Editar Empresa';
                    this.id = data['id_empresa'];
                    this.nombre = data['nom_empresa'];
                    this.representante = data['rep_empresa'];
                    this.tipoAccion = 2;
                    break;
                  }
                }
              }
            }
          },
          cerrarModal () {
            this.$refs.formEmpresa.reset();
            this.dialog = false
          },
          desactivarEmpresa(id) {
              let me = this;

              axios.put('/empresa/desactivar', {
                'id': id
              }).then(function (response) {
                  me.listarEmpresas();
                  // SWEET ALERT
                  swal({
                    type: 'error',
                    title: 'Empresa Desactivada',
                    showConfirmButton: false,
                    timer: 1500
                  })
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                });
            },
            activarEmpresa(id) {
                let me = this;

                axios.put('/empresa/activar', {
                  'id': id
                }).then(function (response) {
                    me.listarEmpresas();
                    // SWEET ALERT
                    swal({
                      type: 'success',
                      title: 'Empresa Activada',
                      showConfirmButton: false,
                      timer: 1500
                    })
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  });
              },
              eliminarEmpresa(id) {
                  let me = this;
                      // SWEET ALERT
                      swal({
                        type: 'warning',
                        title: '¿Desea eliminar definitivamente esta empresa?',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Confirmar',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancelar'
                      }).then((result) => {
                          if (result.value) {
                            swal(
                              '¡Exito!',
                              'La empresa ha sido eliminada',
                              'success'
                            )
                            axios.put('/empresa/delete', {
                              'id': id
                            }).then(function (response) {
                                me.listarEmpresas();
                              })
                          }
                        })

                    .catch(function (error) {
                      // handle error
                      console.log(error);
                    });
                },
              formatDateTime(date) {
                return moment.utc(date, 'YYYY-MM-DD HH:mm').format('HH:mm | DD/MM/YYYY');
              }
              
        },
        mounted() {
            console.log('Componente List Empresas Cargado');
            // Invocar metodo index
            this.listarEmpresas();
        },
        created() {
          //do something after creating vue instance
          this.loading = true;
        }
    }
</script>
