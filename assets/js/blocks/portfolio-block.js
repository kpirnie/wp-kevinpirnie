(function (blocks, element, blockEditor, serverSideRender) {

    const el = element.createElement;
    const { registerBlockType } = blocks;
    const { Placeholder } = wp.components;
    const { useBlockProps } = blockEditor;
    const ServerSideRender = serverSideRender;

    registerBlockType('kpt/portfolio-block', {

        apiVersion: 2,
        title: 'Portfolio Slideshow',
        description: 'Display portfolio items as a slideshow',
        category: 'kpt-blocks',
        icon: 'images-alt2',
        keywords: ['portfolio', 'slideshow', 'gallery', 'projects'],
        supports: {
            anchor: true,
            align: ['wide', 'full'],
        },

        edit: function (props) {

            const blockProps = useBlockProps();

            return el(
                'div',
                blockProps,
                el(
                    ServerSideRender,
                    {
                        block: 'kpt/portfolio-block',
                        attributes: props.attributes
                    }
                )
            );

        },

        save: function () {
            return null;
        }

    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.serverSideRender
);