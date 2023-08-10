(function () {
  'use strict';
  document.addEventListener("DOMContentLoaded", function() {

  	var inputHero = document.getElementById("search-hero");

    var list = [
          { label: "测试", 					        value: "xxx.html" },
        ];

    if (inputHero) {
      inputHero.addEventListener("awesomplete-selectcomplete", function(e) {
        window.location.href = e.text.value;
      }, false);
      
      new Awesomplete(inputHero, {
        autoFirst: true,
        list: list,
        replace: function(suggestion) {
          this.input.value = suggestion.label;
        }
      });
    }


  });

}());
