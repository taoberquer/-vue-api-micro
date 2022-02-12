<template>
  <Card v-for="item in items" :key="item.id">
    <template v-slot:header>
      {{ item.title }}
    </template>
    <template v-slot:content>
      {{ item.content }}
      <div @click="showDetails(item.id)" class="btn btn-primary">View details</div>
    </template>
  </Card>
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
        content: "Image",
      },
          {
            id:"sldkjflxdfksdjflksjd",
        title: "T-shirt",
        content: "Image",
      },
          {
            id:"sldkqksdjflksjd",
        title: "T-shirt",
        content: "Image",
      },
          {
            id:"sldkjflsfdqqsdsdjflksjd",
        title: "T-shirt",
        content: "Image",
      },
      ]
    }
  },
  methods: {
    showDetails(id) {
      this.$router.push(`/items/${id}`);
      // this.$router.push("/login")
    }
  },
};
</script>
