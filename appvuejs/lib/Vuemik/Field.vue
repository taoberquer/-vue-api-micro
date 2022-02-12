<template>
  <component
    :is="component"
    :name="name"
    :checked="vuemik.values[name]"
    :value="value"
    @input="vuemik.change(name, $event.target.value)"
    v-bind="$attrs"
  >
    <slot></slot>
  </component>
</template>
<script>
export default {
  name: "Field",
  props: {
    name: {
      type: String,
      required: true,
    },
    component: {
      type: [Object, String],
      required: true,
    },
  },
  computed: {
    value: function val() {   
      return this.vuemik.values[this.name];
    }
  },
  inject: ["vuemik"],
  methods: {},
};
</script>