<template>
  <div>
    <div 
      class="node"
    >
      <div 
        class="node-content"
        @click="collapsed = !collapsed"
      >
        <span v-if="hasChildren" class="node-icon">
          {{collapsed ? '&#9660;' : '&#9658;'}}
        </span>
        <span v-else class="node-icon">
          &#9671;
        </span>
        {{node.name}}
      </div>
      <tree-browser
        v-if="hasChildren && collapsed"
        v-for="child in node[this.childrenKey]"
        :key="child.id"
        :node="child"
        :childrenKey="childrenKey"
      >
      </tree-browser>
    </div>
  </div>
</template>

<script>
export default {
  name: "TreeBrowser",
  props: {
    node: {
      type: Object,
      default: function() {
        return {
          id: 0,
          name: 'None',
        }
      }
    },
    childrenKey: {
      type: String,
      default: "children"
    },
    indent: {
      type: Number,
      default: 0
    },
  },
  data() {
    return {
      collapsed: true,
    }
  },
  computed: {
    hasChildren() {
      return this.node.hasOwnProperty(this.childrenKey)
    }
  }
}
</script>

<style>
.node {
  padding-left: 1rem;
  user-select: none;
  cursor: pointer;
}
.node .node-content {
  display: flex;
  place-content: center flex-start;
  grid-gap: 1rem;
}
</style>