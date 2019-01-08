<template>

  <div id="dashboard">

    <v-layout row class=" px-4 pt-2 app--page-header">
      <div class="headline">
          <v-icon color="blue">
            home
          </v-icon>
            Dashboard
        </div>
    </v-layout>  

    <v-container grid-list-xl fluid>
      <v-layout row wrap>
        <!-- mini statistic start -->
        <v-flex lg3 sm6 xs12>
          <mini-statistic
            icon="data_usage"
            title="100+"
            sub-title="Likes"
            color="indigo"      
          >
          </mini-statistic>  
        </v-flex>
        <v-flex lg3 sm6 xs12>
          <mini-statistic
            icon="data_usage"
            title="150+"
            sub-title="Connections"
            color="red"      
          >
          </mini-statistic>           
        </v-flex>          
        <v-flex lg3 sm6 xs12>
          <mini-statistic
            icon="data_usage"
            title="200+"
            sub-title="Followers"
            color="light-blue"      
          >
          </mini-statistic>            
        </v-flex>        
        <v-flex lg3 sm6 xs12>
          <mini-statistic
            icon="data_usage"
            title="50+"
            sub-title="Shots"
            color="purple"      
          >
          </mini-statistic>             
        </v-flex>   

      </v-layout>
    </v-container>
  </div>
</template>

<script>

import MiniStatistic from '../widgets/statistic/MiniStatistic';

    export default {

        components: {
          MiniStatistic
        }
        
    }

</script>
