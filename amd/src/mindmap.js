define(['jquery', 'block_smartedu/mind-elixir'], function($, MindElixir) {
  return {
    init: function(mindMapData) {
      mindMapData = JSON.parse(mindMapData);

      const mind = new MindElixir({
          el: '#mindMap',
          editable: false,
          nodeMenu: false,
          data: mindMapData,
      });
      mind.init();
    }
  };
});
