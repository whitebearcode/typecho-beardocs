(function () {
  'use strict';
  document.addEventListener("DOMContentLoaded", function() {


    $(window).scroll(function() {
    if($(this).scrollTop() === 0) {
      $("#gotop").fadeOut();
    }
    else{
       $("#gotop").fadeIn(); 
    }
});
var scrollTop = $(window).scrollTop();
    if (scrollTop === 0) {
        $("#gotop").fadeOut();
    } else {
      $("#gotop").fadeIn(); 
    }


//实时搜索
function searchEngine(query,record){
    return record;
}

const BearDocsSearch = new autoComplete({
  selector: "#searchComplete",
  data: {
    src: async query => {
       const result = await fetch(`${searchApi}?keyword=${query}`);
       const data = result.json();
        document.getElementById("searchComplete").setAttribute("placeholder", BearDocsSearch.placeHolder);
        return data;
    },
    keys: ['article'],
  },
  searchEngine:searchEngine,
  placeHolder: "输入关键词进行实时搜索",
  resultsList: {
    element: (list, data) => {
      //预留方法
    },
    noResults: true,
    maxResults: 100,
    tabSelect: true,
  },
  resultItem: {
    element: (item, data) => {
        //预留方法
    },
    highlight: true,
  },
  events: {
    input: {
      focus() {
        if (BearDocsSearch.input.value.length) BearDocsSearch.start();
      },
      selection(event) {
        const searchResult = event.detail;
        BearDocsSearch.input.blur();
        const selection = searchResult.selection.value;
        window.location.href = selection.url;
        BearDocsSearch.input.value = selection.article;
      },
    },
  },
});

//灯箱
          
          Fancybox.bind('[data-fancybox]', {
      groupAttr:false,
      Toolbar: {
    display: {
      left: ["infobar"],
      middle: [
        "zoomIn",
        "zoomOut",
        "toggle1to1",
        "rotateCCW",
        "rotateCW",
        "flipX",
        "flipY",
      ],
      right: ["slideshow", "thumbs", "close"],
    },
  },
  
  
});
         $('img.lazyload')
  .visibility({
    type       : 'image',
    transition : 'fade in',
    duration   : 1000,
  });




    
    
    


  });

}());
console.log("\n %c BearDocs v1.0.5 %c https://github.com/whitebearcode/typecho-beardocs \n","border-radius:10px 0 0 10px;color: #fadfa3; background: #030307; padding:5px 0;","border-radius:0 10px 10px 0;background: #fadfa3; padding:5px 0;");