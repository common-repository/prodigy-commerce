import { PanelBody, QueryControls, SelectControl, ToggleControl, __experimentalNumberControl as NumberControl, Dashicon } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { withSelect } from '@wordpress/data';
import { categoriesIcon } from '../icons';

const categoriesBlock = {
    title: 'Prodigy Categories',
    icon: categoriesIcon,
    category: 'prodigy',

    // Block attributes.
    attributes: {
        idWidget: {
            type: 'string',
            default: '',
        },
        parentIds: {
            type: 'string',
            default: '',
        },
        product_names: {
            type: 'string',
        },
        columns: {
            type: 'integer',
            default: 4,
        },
        tags: {
            type: 'string',
        },
        orderby: {
            type: 'string',
            default: 'date',
        },
        show_product_count: {
            type: 'boolean',
            default: true
        },
        order: {
            type: 'string',
            default: 'asc',
        },
        display: {
            type: 'string',
            default: 'slider',
        },
    },

    edit: withSelect((select) => {
        const { getEntityRecords } = select('core');
        const categories = getEntityRecords('taxonomy', 'prodigy-product-category', { per_page: -1 });

        // Only return the parent categories with children.
        if (categories) {
            return {
                categories: categories.filter(cat => cat.parent === 0 && cat.count > 0)
            };
        }

        return { categories };
    })(({ categories, attributes, setAttributes }) => {
        const loading = !categories;

        const onChange = (attribute, value) => {
            setAttributes({ [attribute]: value });
        };

        return (
            <div>
                <InspectorControls>
                    <PanelBody title="Categories Selection">
                        {categories && (
                            <QueryControls
                                label="Parent Categories"
                                categoriesList={categories}
                                onCategoryChange={(categoryId) => onChange('parentIds', categories.find(cat => cat.id === parseInt(categoryId))?.prodigyHostedCategoryRelation)}
                                onOrderByChange={(orderBy) => onChange('orderby', orderBy)}
                                onOrderChange={(order) => onChange('order', order)}
                                selectedCategoryId={attributes.categories}
                                order={attributes.order}
                                orderBy={attributes.orderby}
                            />
                        )}
                    </PanelBody>
                    <PanelBody title="Categories Display">
                        <SelectControl
                            label="Display"
                            value={attributes.display}
                            options={[
                                { label: 'Grid', value: 'grid' },
                                { label: 'Slider', value: 'slider' },
                            ]}
                            onChange={(value) => onChange('display', value)}
                        />
                        <NumberControl
                            label="Columns"
                            type="number"
                            value={attributes.columns}
                            min={1}
                            max={6}
                            onChange={(value) => onChange('columns', value)}
                        />
                        <ToggleControl
                            label="Product Count"
                            checked={attributes.show_product_count}
                            onChange={(value) => onChange('show_product_count', value)}
                        />
                    </PanelBody>
                </InspectorControls>
                <div className={`prodigy-${attributes.display}-columns-${attributes.columns}`}>
                    {attributes.display === 'slider' && !loading && (
                        <div className="prodigy-slider-arrow prodigy-slider-arrow-left"><Dashicon icon="arrow-left-alt2" /></div>
                    )}
                    <ServerSideRender
                        block="prodigy/categories"
                        attributes={attributes}
                    />
                    {attributes.display === 'slider' && !loading && (
                        <div className="prodigy-slider-arrow prodigy-slider-arrow-right"><Dashicon icon="arrow-right-alt2" /></div>
                    )}
                </div>
            </div>
        );
    }),
    save: () => null,
};

export default categoriesBlock;