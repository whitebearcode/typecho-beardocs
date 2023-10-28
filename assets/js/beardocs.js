(function () {
  'use strict';
  document.addEventListener("DOMContentLoaded", function() {

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
          Fancybox.bind('[data-fancybox="image"]', {
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

//目录树
    const defaults = Outline.DEFAULTS
    let outline
    defaults.title =  '文档目录', 
    defaults.selector = 'h1,h2,h3,h4,h5,h6',
    defaults.position = 'relative',
    defaults.showCode = false,
    defaults.articleElement = '.uk-article-content',
    outline = new Outline(Outline.DEFAULTS)
    
    
    
    


  });

}());
