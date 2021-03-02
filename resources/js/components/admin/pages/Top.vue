<template>
  <div>
       <a id="button"></a>
  </div>
</template>

<script>
export default {
  data() {
    return {
      
    }
  },
  methods: {
    goTopButton() {
      var btn = $("#button");
      $(window).scroll(function () {
        if ($(window).scrollTop() > 300) {
          btn.addClass("show");
        } else {
          btn.removeClass("show");
        }
      });
      btn.on("click", function (e) {
        e.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, "300");
      });
    },
  },
  mounted () {
       this.goTopButton();
  },
};
</script>