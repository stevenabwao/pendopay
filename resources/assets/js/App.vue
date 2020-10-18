<template>

    <div>
        
        <router-view
            class="view"
            keep-alive
            transition
            transition-mode="out-in">
            
        </router-view>

      </div>

</template>


<script>

    export default {
        
        created(){
            
        }

    }

</script>

<style>

  .view{transition: opacity .2s ease}
  
</style>
