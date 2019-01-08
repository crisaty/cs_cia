<template>
  <v-app id="login" class="primary">
    <v-content>
      <v-container fluid fill-height >
        <v-layout align-center justify-center>
          
          <v-flex xs12 sm8 md4 lg3 class="animated fadeInUp" >
            <v-card id="card" class="elevation-5 pa-3" >
              
              <v-card-text>
                <v-img contain max-height="150" src="images/icon/logo-blue.png"></v-img>
                <div class="layout column align-center">
                  <h1 class="flex my-4 primary--text font-weight-light">Inicio de Sesión</h1>
                </div>      
                <v-form v-model="valid" lazy-validation>
                  <v-text-field box append-icon="person" v-model="email" id="email" name="email" 
                    label="Correo" placeholder="user@mail.com" required type="text"
                    :rules="[validar.required, validar.email]">
                  </v-text-field>
                  <v-text-field box append-icon="lock" v-model="password" id="password" name="password"
                    label="Password" placeholder="*********" required type="password"
                    :rules="[validar.required]">
                  </v-text-field>
                  <v-flex text-xs-center>
                    <v-btn :disabled="!valid" large color="primary darken-1" @click="login" :loading="loading">LOGIN</v-btn>
                  </v-flex>
                </v-form>
              </v-card-text>

            </v-card>
          </v-flex>
          
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>


<script>

export default {
  data: () => ({
    loading: false,
    email: '',
    password: '',
    valid: false,
    validar: {
      required: val => !!val || 'Campo Requerido.',
      email: val => /.+@.+/.test(val) || 'Ingrese un Mail Valido.'
    },
  }),

  methods: {
    login () {

      this.loading = true;
      
      axios.post('/login', {
          email: this.email,
					password: this.password
      }).then(response => {
          location.reload();
      }).catch(error => {
          location.reload();
      });

    }
  }

};
</script>

<style scoped lang="css">

  #login {
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    content: "";
    z-index: 0;
    background-image: url('/images/bg-login.png');
  }

  #card {
    border-radius: 25px;
  }
  
</style>

