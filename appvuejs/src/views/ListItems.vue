<template>
  <div class="panel">
    <div class="separator mb-2">{{ nbItems }} items found</div>
    <div class="panel-body row justify-content-center">
      <Card class="col-2 m-2 flex-column" v-for="item in items" :key="item.id">
        <template v-slot:img>
          <!--<img :src="item.thumbnail" />-->
          <img class="pointer" @click="showDetails(item.id)" src="../assets/test.png" contain height="300" />
        </template>
        <template v-slot:infos>
          <h4>{{ item.title }}</h4>
          <p>{{ item.price }} €</p>
        </template>
      </Card>
    </div>
  </div>
</template>

<script>
import Card from "../components/Card";

export default {
  components: {
    Card,
  },
  data() {
    return {
      items: [
          {
            id:"sldkjflksdjflksjd",
        title: "T-shirt",
        thumbnail: "../assets/logo.png",
        price: "10",
      },
          {
            id:"sldkjflxdfksdjfffd",
        title: "T-shirt",
        thumbnail: "../assets/logo.png",
        price: "10",
      },
          {
            id:"sldkqksdjflksjd",
        title: "T-shirt",
        thumbnail: "../assets/logo.png",
        price: "10",
      },
          {
            id:"sldkbnjdsdjflksjd",
        title: "T-shirt",
        thumbnail: "../assets/logo.png",
        price: "10",
      },
      {
            id:"sldkjflsfdqqzertdjflksjd",
        title: "T-shirt",
        thumbnail: "../assets/logo.png",
        price: "10",
      },
      {
            id:"sldkjflsfdqhjyfjd",
        title: "T-shirt",
        thumbnail: "../assets/logo.png",
        price: "10",
      },
      {
            id:"sldkjflsfdqqsnujd",
        title: "T-shirt",
        thumbnail: "../assets/logo.png",
        price: "10",
      },
      {
            id:"sldkjflsfdqqscvsksjd",
        title: "T-shirt",
        thumbnail: "../assets/logo.png",
        price: "10",
      },
      {
            id:"sldkjflsfdqqsdscvnfgjd",
        title: "T-shirt",
        thumbnail: "../assets/logo.png",
        price: "10",
      },
      {
            id:"sldkjflsfdqqsdsghjijd",
        title: "T-shirt",
        thumbnail: "../assets/logo.png",
        price: "10",
      },
      {
            id:"sldkjflsfdqqsdsdjflshrjyksjd",
        title: "T-shirt",
        thumbnail: "../assets/logo.png",
        price: "10",
      },
      {
            id:"sldkjflsfdqqsdsdjefzghd",
        title: "T-shirt",
        thumbnail: "../assets/logo.png",
        price: "10",
      },
      ],
    }
  },
  computed: {
      nbItems() {
        return this.items.length;
      },
    },
  methods: {
    showDetails(id) {
      this.$router.push(`/items/${id}`);
      // this.$router.push("/login")
    }
  },
};
</script>
