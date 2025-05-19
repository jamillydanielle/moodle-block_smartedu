define(['jquery', 'block_smartedu/mind-elixir'], function($, MindElixir) {
  return {
    init: function(mindMapData) {
      let jsonData = mindMapData;
      if (typeof mindMapData === 'string') {
        jsonData = JSON.parse(mindMapData);
      }
        window.console.log(jsonData);
        const mind = new MindElixir({
            el: '#mindMap',
            editable: false,
            nodeMenu: false,
            data: jsonData,
        });
        mind.init();
    }
  };
});
