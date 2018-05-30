new Vue({
    el: '#form',
    data:{
      postcomment: ''
    },
    computed: {
      textAreaLength: function(){
        return 140 - this.postcomment.length;
      }
    }
  })