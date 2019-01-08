<template id="productos">

  <div id="main-div">

        <v-layout row class=" px-4 pt-2 app--page-header">
          <div class="headline">
            <v-icon medium color="blue">
              dashboard
            </v-icon>
              Listado de Productos
          </div>
        </v-layout>

      <v-container grid-list-md fluid>

      <v-toolbar dense flat color="grey lighten-3" class="elevation-1" style="overflow-x: auto;">
        <v-btn flat color="success" @click="abrirModal('producto','registrar')">
            Nuevo Producto 
        </v-btn>
        <v-menu offset-y>
          <v-btn dense flat
            slot="activator"
            color="primary"
            dark
          >
            Exportar
          </v-btn>
          <v-list>
            <v-list-tile
              v-for="(item, index) in menuExportar"
              :key="index"
              @click=""
            >
              <v-list-tile-title>{{ item.title }}</v-list-tile-title>
            </v-list-tile>
          </v-list>
        </v-menu>
        <v-spacer></v-spacer>
        <v-btn-toggle mandatory
          v-model="tipoVista"
          class="transparent"
        >
          <v-btn :value="1" flat>
            <v-icon>view_list</v-icon>
          </v-btn>

          <v-btn :value="2" flat>
            <v-icon>view_column</v-icon>
          </v-btn>

        </v-btn-toggle>
      </v-toolbar>
      <v-toolbar dense color="white" class="elevation-1">
        <v-text-field
          flat solo
          prepend-icon="search"
          placeholder="Busqueda..."
          v-model="buscar" hide-details
          ></v-text-field>
      </v-toolbar>

      <div v-if="tipoVista == 1">

          <v-data-table 
            :headers="headers"
            :items="arrayProducto"
            :pagination.sync="pagination"
            :loading="loading"
            :search="buscar"
            class="elevation-1">
            <template slot="items" slot-scope="props">
                <td>{{props.item.nom_producto}}</td>
                <td>{{props.item.tipo}}</td>
                <td>$ {{props.item.precio_costo}}</td>
                <td>$ {{props.item.precio_venta}}</td>
                <td>{{ formatDateM(props.item.fecha_exp) }}</td>
                <td>
                  <div v-if="props.item.info!=null">
                    <v-menu
                      transition="slide-y-transition"
                      offset-y left
                    >
                    <v-btn slot="activator" color="indigo" flat small round>
                       Mostrar Info <v-icon right>add_circle_outline</v-icon>
                    </v-btn>
                      <v-card max-width="250">
                        <v-card-title class="indigo lighten-1">
                          <div class="title white--text">{{ props.item.nom_producto }}</div>
                        </v-card-title>                       
                        <v-card-text >
                          <div v-html="props.item.info"></div>
                        </v-card-text>              
                      </v-card>
                    </v-menu>
                  </div>
                  <div v-else>
                    <v-chip small outline>Sin Info. Adicional</v-chip>
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
                    <v-btn flat small round  color="primary" @click="abrirModal('producto','editar', props.item)">
                        Editar
                    </v-btn>
                    <template v-if="props.item.estado==1">
                      <v-btn flat small round color="warning darken-2" @click="desactivarProducto(props.item.id_producto)" >
                          Desactivar
                      </v-btn>
                      <v-tooltip left>
                        <v-btn flat small icon color="indigo" @click="enviarAlertaExp(props.item.cliente_id_cliente, props.item.id_producto)" slot="activator" >
                          <v-icon>confirmation_number</v-icon>
                        </v-btn>
                      <span>Enviar Alerta de Expiracion</span>
                      </v-tooltip>
                    </template>
                    <template v-else>
                      <v-btn flat small round color="success" @click="activarProducto(props.item.id_producto)" >
                          Activar
                      </v-btn>
                    </template>
                    <v-btn flat small icon  color="error darken-2" @click="eliminarProducto(props.item.id_producto)" >
                      <v-icon>cancel</v-icon>
                    </v-btn>
                  </v-flex>
                </td>
              </template>

              <v-alert outline slot="no-results" transition="slide-y-reverse-transition" color="grey darken-1" :value="true" icon="info">
                  La busqueda para "{{ buscar }}" no encuentra registros asociados.
              </v-alert>

            </v-data-table>

        </div>

      <div v-if="tipoVista == 2">
      <template>
        <v-container grid-list-xl>
          <v-data-iterator
            :items="arrayProducto"
            :pagination.sync="pagination"
            :search="buscar"
            :loading="loading"
            content-tag="v-layout"
            row wrap
          >
            <v-flex
              slot="item"
              slot-scope="props"
              xs12 sm6 md4 lg3
            >
              <v-card class="elevation-3">

              <v-toolbar flat height="30">
                <div v-if="props.item.estado">
                  <span class="success--text">Activo</span>
                </div>
                <div v-else>
                  <span class="error--text">Desactivado</span>
                </div>
                <v-spacer></v-spacer>
                <template v-if="props.item.estado==1">
                  <v-tooltip bottom>
                    <v-btn flat small icon color="indigo" @click="enviarAlertaExp(props.item.cliente_id_cliente, props.item.id_producto)" slot="activator" >
                      <v-icon>confirmation_number</v-icon>
                    </v-btn>
                  <span>Enviar Alerta de Expiracion</span>
                  </v-tooltip>
                </template>
                
                <v-btn flat small icon color="error darken-2" @click="eliminarProducto(props.item.id_producto)" >
                  <v-icon>cancel</v-icon>
                </v-btn>
              </v-toolbar>

                <div v-if="props.item.tipo=='Hosting'">
                  <v-img src="images/icon/hosting.jpg" aspect-ratio="2.75"></v-img>
                </div>
                <div v-if="props.item.tipo=='Dominio'">
                  <v-img src="images/icon/dominio.jpg" aspect-ratio="2.75"></v-img>
                </div>
                <div v-if="props.item.tipo=='Gmail'">
                  <v-img src="images/icon/gmail.jpg" aspect-ratio="2.75"></v-img>
                </div>
                <div v-if="props.item.tipo=='Producto'">
                  <v-img src="images/icon/producto.jpg" aspect-ratio="2.75"></v-img>
                </div>
                <div v-if="props.item.tipo=='Servicio'">
                  <v-img src="images/icon/servicio.jpg" aspect-ratio="2.75"></v-img>
                </div>

                <v-card-title primary-title>
                  <div>
                    <h3 class="headline mb-0">{{ props.item.nom_producto }}</h3>
                    <div>Actualizacion: {{ formatDateTime(props.item.updated_at) }}</div>
                  </div>
                </v-card-title>

                 <v-list>
                  <v-list-tile>
                    <v-list-tile-action>
                      <v-icon>attach_money</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                      <v-list-tile-title>{{ props.item.precio_costo }}</v-list-tile-title>
                      <v-list-tile-sub-title>Precio Costo</v-list-tile-sub-title>
                    </v-list-tile-content>
                  </v-list-tile>
                  <v-divider></v-divider>
                  <v-list-tile>
                    <v-list-tile-action>
                      <v-icon>attach_money</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                      <v-list-tile-title>{{ props.item.precio_venta }}</v-list-tile-title>
                      <v-list-tile-sub-title>Precio Venta</v-list-tile-sub-title>
                    </v-list-tile-content>
                  </v-list-tile>
                  <v-divider></v-divider>
                  <v-list-tile>
                    <v-list-tile-action>
                      <v-icon>event</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                      <v-list-tile-title>{{ formatDateM(props.item.fecha_exp) }}</v-list-tile-title>
                      <v-list-tile-sub-title>Fecha de Expiracion</v-list-tile-sub-title>
                    </v-list-tile-content>
                  </v-list-tile>

                </v-list>

                <template v-if="props.item.info!=null">
                  <v-expansion-panel expand style="margin: 10px 20px 0px 0px;">
                    <v-expansion-panel-content>
                      <div slot="header">Mostrar Info. Adicional</div>
                      <v-card-text>
                        <div v-html="props.item.info"></div>
                      </v-card-text>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                </template>
                <template v-else>
                  <v-expansion-panel expand style="margin: 10px 20px 0px 0px;">
                    <v-expansion-panel-content>
                      <v-icon slot="actions">more_horiz</v-icon>
                      <div slot="header">Sin Info. Adicional</div>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                </template>
                
                <v-card-actions>
                  <v-flex>
                    
                    <v-btn flat outline color="primary" @click="abrirModal('producto','editar', props.item)">
                      Editar
                    </v-btn>
                    <template v-if="props.item.estado==1">
                      <v-btn flat outline color="warning darken-2" @click="desactivarProducto(props.item.id_producto)" >
                          Desactivar
                      </v-btn>
                    </template>
                    <template v-else>
                      <v-btn flat outline color="success" @click="activarProducto(props.item.id_producto)" >
                          Activar
                      </v-btn>
                    </template>
                  </v-flex>
                </v-card-actions>
              </v-card>
            </v-flex>
          </v-data-iterator>
        </v-container>
      </template>
      </div>

      <!-- MODAL -->
        <v-dialog v-model="dialog" persistent max-width="600px" max-height="600px" ref="modalProductos" @hidden="cerrarModal">
          <v-card>
            <v-card-title
              class="headline grey lighten-3">{{ tituloModal }}
            </v-card-title>

            <v-form ref="formProducto" v-model="valid" lazy-validation>

              <v-container grid-list-md>
              <v-layout wrap>

                <v-flex sm6>
                  <v-select
                    v-model="idCliente"
                    :items="arrayCliente"
                    item-text="nom_cliente"
                    item-value="id_cliente"
                    :rules="[validar.required]"
                    label="Cliente"
                    required placeholder="Seleccionar"
                  ></v-select>
                </v-flex>

                <v-flex sm6>
                  <v-text-field 
                    :rules="[validar.required, validar.counter]"
                    counter maxlength="40"
                    label="Nombre del Producto / Servicio" type="text" 
                    v-model="nombre" ref="nombre"
                    placeholder="Computador X"
                  ></v-text-field>
                </v-flex>
              
                <v-flex sm3>
                  <v-select
                    v-model="idTipoProducto"
                    :items="arrayTipoProducto"
                    item-text="nom_tipoproducto"
                    item-value="id_tipoproducto"
                    :rules="[validar.required]"
                    label="Tipo / Categoria"
                    required placeholder="Seleccionar"
                  ></v-select>
                </v-flex>

                <v-flex sm3>
                  <v-dialog
                    ref="dialog" v-model="datepicker"
                    full-width width="290px"
                  >
                    <v-text-field
                      slot="activator"
                      label="Fecha Ingreso"
                      readonly
                      placeholder="Seleccionar"
                      :value="formatDateM(fechaIngreso)"
                    ></v-text-field>
                    <v-date-picker v-model="fechaIngreso" scrollable locale="es" 
                      first-day-of-week="1" @input="$refs.dialog.save(fechaIngreso)">
                    </v-date-picker>
                  </v-dialog>
                </v-flex>
                <v-flex sm3>
                  <v-currency-field label="Precio Costo" v-bind="money" 
                   v-model="precioCosto" :rules="[validar.required, validar.precio]">
                  </v-currency-field>
                </v-flex>
                <v-flex sm3>
                  <v-currency-field label="Precio Venta" v-bind="money" 
                   v-model="precioVenta" :rules="[validar.required, validar.precio]">
                  </v-currency-field>
                </v-flex>
                <v-flex sm12>
                  <div class="title grey--text">Información Adicional</div>
                  <v-divider></v-divider>
                  <vue-editor v-model="info" :editorToolbar="customToolbar" 
                    placeholder="Info. relacionada al producto / servicio (opcional)">
                  </vue-editor>
                </v-flex>
                <v-chip>{{precioCosto}} {{convertfrom}} son aproximadamente {{finalamount}} {{convertto}}</v-chip>
              </v-layout>
            </v-container>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn flat @click="cerrarModal()" >Cancelar</v-btn>
              <v-btn :disabled="!valid" color="success" flat @click="registrarProducto()" v-if="tipoAccion==1" >Registrar</v-btn>
              <v-btn :disabled="!valid" color="info" flat @click="editarProducto()" v-if="tipoAccion==2" >Actualizar</v-btn>
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

        <v-dialog
        v-model="expAlerta"
        hide-overlay
        persistent
        width="300"
        >
          <v-card
            color="primary"
            dark
          >
            <v-card-text>
              Enviando Correo de Alerta...
              <v-progress-linear
                indeterminate
                color="white"
                class="mb-0"
              ></v-progress-linear>
            </v-card-text>
          </v-card>
        </v-dialog>

      </v-container>

  </div>

</template>

<script>

import { VueEditor } from "vue2-editor";

var moment = require('moment');

    export default {

      components: { VueEditor },

        data() {
            return {
              id: 0,
              idCliente: 0,
              arrayCliente: [],
              nombre: '',
              precioCosto: 0,
              precioVenta: 0,
              fechaIngreso: '',
              info: '',
              arrayProducto : [],
              tituloModal: '',
              tipoAccion: 0,
              criterio: 0,
              idTipoProducto: 0,
              arrayTipoProducto : [],
              tipoVista : 1,
              money: {
                decimal: ',',
                thousands: '.',
                precision: 0,
                masked: true
              },
              change:'',
              currencyfrom : [
               {change:"USD", desc:"Dolares", usd: 0},
               {change:"CLP", desc:"Pesos Chilenos"},
              ],
              convertfrom: "USD",
              convertto: "CLP",
              // MODAL DIALOG
              dialog: false,
              tituloModal: '',
              tipoAccion: 0,
              // DATATABLE
              headers: [
                { text: 'Nombre', value: 'nom_producto' },
                { text: 'Tipo', value: 'tipo' },
                { text: 'Precio Costo', value: 'precio_costo' },
                { text: 'Precio Venta', value: 'precio_venta' },
                { text: 'Fecha Expiracion', value: 'fecha_exp' },
                { text: 'Info. Adicional', value: 'info', sortable: false },
                { text: 'Estado', value: 'estado' },
                { text: 'Actualizacion', value: 'updated_at' },
                { text: 'Acciones / Opciones', align: 'center', sortable: false }
              ],
              pagination: {
                sortBy: '',
                rowsPerPage: 10
              },
              buscar: '',
              // VALIDACIONES
              valid: false,
              validar: {
                required: val => !!val || 'Campo Requerido.',
                counter: val => (val && val.length <= 40) || 'Maximo 40 Caracteres.',
                precio: val => (val > 0 && val <= 9999999 ) || 'Precio invalido'
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
              menuInfo: false,
              datepicker: false,
              customToolbar: [
                [{"header":[false,3,4,5,6]}],
                [{ align: "" }, { align: "center" }, { align: "right" }, { align: "justify" }],
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["link","image","blockquote","clean"]
              ],
              expAlerta: false,
              cardInfo: false
            }
        },
        methods : {
          listarProductos(criterio) {
            let me = this;
            var url = '/producto';

            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayProducto = respuesta.productos;
                me.loading = false;
              })
              .catch(function (error) {
                // handle error
                me.loading = false;
                console.log(error);
              });
          },
          filtroProductos(criterio) {
            let me = this;
            var url = '/producto?criterio='+ criterio;

            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayProducto = respuesta.productos;
                me.loading = false;
              })
              .catch(function (error) {
                // handle error
                me.loading = false;
                console.log(error);
              });
          },
          selectCliente() {
            let me = this;
            var url = '/producto/selectCliente';

            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayCliente = respuesta.clientes;
              })
              .catch(function (error) {
                // handle error
                console.log(error);
              });
          },
          selectTipo() {
            let me = this;
            var url = '/producto/selectTipoProducto';

            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayTipoProducto = respuesta.tipos_productos;
              })
              .catch(function (error) {
                // handle error
                console.log(error);
              });
          },
          registrarProducto () {
            if (this.$refs.formProducto.validate()) {

              let me = this;

              axios.post('/producto/registrar', {
                'idCliente': this.idCliente,
                'idTipoProducto': this.idTipoProducto,
                'nombre': this.nombre,
                'fechaIngreso': this.fechaIngreso,
                'precioCosto': this.precioCosto,
                'precioVenta': this.precioVenta,
                'info': this.info,
              }).then(function (response) {
                  me.cerrarModal();
                  me.listarProductos('');
                  me.snackbar_text = 'Producto Registrado Exitosamente'
                  me.snackbar = true;
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                });
            }
          },
          editarProducto () {
            if (this.$refs.formProducto.validate()) {

              let me = this;

              axios.put('/producto/actualizar', {
                'id': this.id,
                'idCliente': this.idCliente,
                'idTipoProducto': this.idTipoProducto,
                'nombre': this.nombre,
                'fechaIngreso': this.fechaIngreso,
                'precioCosto': this.precioCosto,
                'precioVenta': this.precioVenta,
                'info': this.info,
              }).then(function (response) {
                  me.cerrarModal();
                  me.listarProductos('');
                  me.snackbar_text = 'Producto Actualizado Exitosamente'
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
              case "producto":
              {
                switch (accion) {
                  case 'registrar':
                  {
                    this.$refs.formProducto.reset();
                    this.tituloModal = 'Nuevo Producto';
                    this.fechaIngreso = new Date().toISOString().substr(0, 10),
                    this.tipoAccion = 1;
                    break;
                  }
                  case 'editar':
                  {
                    console.log(data);
                    this.tituloModal = 'Editar Producto';
                    this.id = data['id_producto'];
                    this.idCliente = data['cliente_id_cliente'];
                    this.idTipoProducto = data['tipo_producto_id_tipoproducto'];
                    this.nombre = data['nom_producto'];
                    this.fechaIngreso = data['fecha_exp'];
                    this.precioCosto = data['precio_costo'];
                    this.precioVenta = data['precio_venta'];
                    this.info = data['info'];
                    this.tipoAccion = 2;
                    break;
                  }
                }
              }
            }
            this.selectCliente();
            this.selectTipo();
          },
          cerrarModal (evt) {
            this.dialog = false,
            this.nombre = '',
            this.fechaIngreso = '',
            this.precioCosto = 0,
            this.precioVenta = 0,
            this.info = ''
          },
          desactivarProducto(id) {
              let me = this;

              axios.put('/producto/desactivar', {
                'id': id
              }).then(function (response) {
                  me.listarProductos('');
                  // SWEET ALERT
                  swal({
                    type: 'error',
                    title: 'Producto Desactivado',
                    showConfirmButton: false,
                    timer: 1500
                  })
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                });
            },
            activarProducto(id) {
                let me = this;

                axios.put('/producto/activar', {
                  'id': id
                }).then(function (response) {
                    me.listarProductos('');
                    // SWEET ALERT
                    swal({
                      type: 'success',
                      title: 'Producto Activado',
                      showConfirmButton: false,
                      timer: 1500
                    })
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  });
              },
              enviarAlertaExp(id_cli, id_pro) {
                let me = this;

                this.expAlerta = true;

                axios.put('/producto/enviarAlertExp', {
                  'id_cliente': id_cli,
                  'id_producto': id_pro
                }).then(function (response) {
                    // SWEET ALERT
                    swal({
                      type: 'success',
                      title: 'Correo Enviado',
                      showConfirmButton: false,
                      timer: 1000
                    })
                    me.expAlerta = false;
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  });
              },
              eliminarProducto(id) {
                  let me = this;

                      // SWEET ALERT
                      swal({
                        type: 'warning',
                        title: '¿Desea eliminar definitivamente este producto/servicio?',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Confirmar',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancelar'
                      }).then((result) => {
                          if (result.value) {
                            swal(
                              '¡Exito!',
                              'El producto/servicio ha sido eliminado',
                              'success'
                            )
                            axios.put('/producto/delete', {
                              'id': id
                            }).then(function (response) {
                                me.listarProductos('');
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
              cambioVista(tipoVista) {
                switch (tipoVista) {
                  case 1:
                  {
                    this.tipoVista = 1;
                    break;
                  }
                  case 2:
                  {
                    this.tipoVista = 2;
                    break;
                  }
                }
              }
        },
        mounted() {
            console.log('Componente List Productos Cargado');
            // Invocar metodo index
            this.listarProductos('');
            //this.abrirModal('producto','registrar');
        },
        created() {
            //do something after creating vue instance
            this.loading = true;
        },
        computed: {
          finalamount:function() {

            var https = require('https');
            let me = this;

            https.get('https://mindicador.cl/api', function(res) {
                res.setEncoding('utf-8');
                var data = '';
                res.on('data', function(chunk) {
                    data += chunk;
                });
                res.on('end', function() {
                    var dailyIndicators = JSON.parse(data); // JSON to JavaScript object
                    me.usd = dailyIndicators.dolar.valor;
                });
            
            }).on('error', function(err) {
                console.log('Error al consumir la API!');
            });

            var to = this.convertto;
            var from = this.convertfrom;
            var final;
            switch(from) {
              case "USD":
                if (to == "CLP") {
                  final = this.precioCosto * this.usd;
                }
                break;
              case "CLP":
                if (to == "USD") {
                  final = this.precioCosto / this.usd;
                }
                break;
            }
            return final;
          },
          formatDate() {
            return this.fechaIngreso ? moment(this.fechaIngreso).format('DD/MM/YYYY') : ''
          }
        }
    }

</script>
