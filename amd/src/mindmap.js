define(['jquery', 'block_smartedu/mind-elixir'], function($, MindElixir) {
  return {
    init: function(jsonData) {
        window.console.log(jsonData);

        const data = {
        nodeData: {
            id: 'd451a556d866ba7b',
            topic: 'new topic',
            root: true,
            children: [
            {
                topic: 'new node',
                id: 'd451a6f027c33b1f',
                direction: 0,
                children: [
                {
                    topic: 'new node',
                    id: 'd451a724b7c10970',
                },
                {
                    topic: 'new node',
                    id: 'd451a77ca7348eae',
                },
                {
                    topic: 'new node',
                    id: 'd451a78e1ec7181c',
                },
                ],
            },
            ],
        },
        arrows: [
            {
            id: 'd451a9149a1e3a15',
            label: 'Custom Link',
            from: 'd451a77ca7348eae',
            to: 'd451a78e1ec7181c',
            delta1: {
                x: -230,
                y: -9,
            },
            delta2: {
                x: -236,
                y: 14,
            },
            },
        ],
        };

        const mind = new MindElixir({
            el: '#mapaMental',
            direction: MindElixir.SIDE,
            editable: false,
            contextMenu: false,
            toolbar: false,
            data: data,
        });
        mind.init();
    }
  };
});
