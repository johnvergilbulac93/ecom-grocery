<template>
  <div>
       <a id="button" data-toggle="tooltip" title="GO UP"></a>
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
        if ($(window).scrollTop() > 460) {
          btn.addClass("show");
        } else {
          btn.removeClass("show");
        }
      });
      btn.on("click", function (e) {
        e.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, "460");
      });
    },
  },
  mounted () {
       this.goTopButton();
  },
};
</script>