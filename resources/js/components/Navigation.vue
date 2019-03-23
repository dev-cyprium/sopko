<template>
    <v-navigation-drawer permanent app dark>
    <v-toolbar flat>
      <v-list>
        <v-list-tile>
          <v-list-tile-title class='title'>
            Šopko
          </v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-toolbar>

    <v-divider></v-divider>

    <v-list dense class='pt-0'>
      <v-list-tile
        v-for='item in items'
        :key='item.title'
        @click='handleRouteClick(item.action)'
      >
        <v-list-tile-action>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>{{ item.title }}</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
export default {
    data() {
        return {
            items: [
                {title: 'Proizvodi', icon: 'business_center', action: {route: '/'}},
                {title: 'Kategorije Proizvoda', icon: 'category', action: {route: '/categories'}},
                {title: 'Skadište', icon: 'dns', action: {route: '/storage'}},
                {title: 'Slike', icon: 'image', action: {route: '/images_manage'}},
                {title: 'Izveštaji', icon: 'receipt', action: {route: '/reports'}},
                {title: 'Odjavi Se', icon: 'exit_to_app', action: {dispatch: 'logout', route: '/login'}},
            ]
        }
    },
    methods: {
      handleRouteClick({route, dispatch}) {
        if(route) {
          this.$router.push(route);
        } 
        
        if(dispatch) {
           this.$store.dispatch(dispatch)
              .then(() => this.$router.push(route))
        }
      }
    }
}
</script>
