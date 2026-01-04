(function (blocks, element, blockEditor, components, serverSideRender) {

    const el = element.createElement;
    const { registerBlockType } = blocks;
    const { SelectControl, Placeholder } = components;
    const { useBlockProps, InspectorControls } = blockEditor;
    const { PanelBody } = components;

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
                default: 'portfolio-masonry'
            }
        },

        edit: function (props) {

            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            const imageSizeOptions = [
                { value: 'portfolio-masonry', label: 'Portfolio Masonry (800x600)' },
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
                            onChange: function (value) { setAttributes({ imageSize: value }); },
                            help: 'Select the image size to use for portfolio items'
                        })
                    )
                ),
                el(
                    'div',
                    { className: 'kpt-portfolio-preview', style: { columnCount: '3', columnGap: '1rem', padding: '1rem', background: '#1f2937', borderRadius: '0.5rem' } },
                    el('div', { style: { breakInside: 'avoid', marginBottom: '1rem', height: '256px', background: 'linear-gradient(135deg, #599bb8 0%, #2d7696 100%)', borderRadius: '0.375rem', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '14px' } }, 'Portfolio Item 1'),
                    el('div', { style: { breakInside: 'avoid', marginBottom: '1rem', height: '320px', background: 'linear-gradient(135deg, #43819c 0%, #1c375c 100%)', borderRadius: '0.375rem', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '14px' } }, 'Portfolio Item 2'),
                    el('div', { style: { breakInside: 'avoid', marginBottom: '1rem', height: '384px', background: 'linear-gradient(135deg, #2d7696 0%, #000d2d 100%)', borderRadius: '0.375rem', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '14px' } }, 'Portfolio Item 3'),
                    el('div', { style: { breakInside: 'avoid', marginBottom: '1rem', height: '288px', background: 'linear-gradient(135deg, #599bb8 0%, #2d7696 100%)', borderRadius: '0.375rem', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '14px' } }, 'Portfolio Item 4'),
                    el('div', { style: { breakInside: 'avoid', marginBottom: '1rem', height: '256px', background: 'linear-gradient(135deg, #43819c 0%, #1c375c 100%)', borderRadius: '0.375rem', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '14px' } }, 'Portfolio Item 5'),
                    el('div', { style: { breakInside: 'avoid', marginBottom: '1rem', height: '320px', background: 'linear-gradient(135deg, #2d7696 0%, #000d2d 100%)', borderRadius: '0.375rem', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '14px' } }, 'Portfolio Item 6')
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