(function (blocks, element, blockEditor, components, serverSideRender) {

    const el = element.createElement;
    const { registerBlockType } = blocks;
    const { SelectControl } = components;
    const { useBlockProps, InspectorControls } = blockEditor;
    const { PanelBody } = components;
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
        attributes: {
            imageSize: {
                type: 'string',
                default: 'portfolio'
            }
        },

        edit: function (props) {

            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            const imageSizeOptions = [
                { value: 'portfolio', label: 'Portfolio (1920x350)' },
                { value: 'hero', label: 'Hero (1920x350)' },
                { value: 'articlehead', label: 'Article Head (963x385)' },
                { value: 'articlelist', label: 'Article List (520x193)' },
                { value: 'innerpage', label: 'Inner Page (482x397)' },
                { value: 'full', label: 'Full Size' },
                { value: 'large', label: 'Large' },
                { value: 'medium_large', label: 'Medium Large' },
                { value: 'medium', label: 'Medium' },
                { value: 'thumbnail', label: 'Thumbnail' },
            ];

            return el(
                'div',
                blockProps,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: 'Image Settings', initialOpen: true },
                        el(SelectControl, {
                            label: 'Image Size',
                            value: attributes.imageSize,
                            options: imageSizeOptions,
                            onChange: function(value) { setAttributes({ imageSize: value }); },
                            help: 'Select the image size to use for portfolio items'
                        })
                    )
                ),
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
    window.wp.components,
    window.wp.serverSideRender
);