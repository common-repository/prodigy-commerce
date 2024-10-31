import { PanelBody, QueryControls, SelectControl, ToggleControl, __experimentalNumberControl as NumberControl, Dashicon } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { withSelect } from '@wordpress/data';
import { productsIcon } from '../icons';

const productsBlock = {
    title: 'Prodigy Products',
    icon: productsIcon,
    category: 'prodigy',

    // Block attributes.
    attributes: {
        idWidget: {
            type: 'string',
            default: '',
        },
        categoryIds: {
            type: 'string',
            default: '',
        },
        columns: {
            type: 'integer',
            default: 4,
        },
        limit: {
            type: 'integer',
            default: 9,
        },
        tags: {
            type: 'string',
        },
        orderby: {
            type: 'string',
            default: 'date',
        },
        on_sale: {
            type: 'boolean',
            default: false,
        },
        sale: {
            type: 'boolean',
            default: true
        },
        category: {
            type: 'boolean',
            default: true
        },
        rating: {
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

        return { categories };
    })(({ categories, attributes, setAttributes }) => {
        const loading = !categories;

        const onChange = (attribute, value) => {
            setAttributes({ [attribute]: value });
        };

        return (
            <div>
                <InspectorControls>
                    <PanelBody title="Products Selection">
                        {categories && (
                            <QueryControls
                                label="Select Categories"
                                categoriesList={categories}
                                onCategoryChange={(categoryId) => onChange('categoryIds', categories.find(cat => cat.id === parseInt(categoryId))?.prodigyHostedCategoryRelation)}
                                onNumberOfItemsChange={(numberOfItems) => onChange('limit', numberOfItems)}
                                onOrderByChange={(orderBy) => onChange('orderby', orderBy)}
                                onOrderChange={(order) => onChange('order', order)}
                                selectedCategoryId={attributes.categories}
                                numberOfItems={attributes.limit}
                                order={attributes.order}
                                orderBy={attributes.orderby}
                            />
                        )}
                        <SelectControl
                            label="On Sale"
                            value={attributes.on_sale}
                            options={[
                                { label: 'On Sale', value: true },
                                { label: 'All', value: false },
                            ]}
                            onChange={(value) => onChange('on_sale', value)}
                        />
                    </PanelBody>
                    <PanelBody title="Products Display">
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
                            label="Show Sale"
                            checked={attributes.sale}
                            onChange={(value) => onChange('sale', value)}
                        />
                        <ToggleControl
                            label="Show Category"
                            checked={attributes.category}
                            onChange={(value) => onChange('category', value)}
                        />
                        <ToggleControl
                            label="Show Rating"
                            checked={attributes.rating}
                            onChange={(value) => onChange('rating', value)}
                        />
                    </PanelBody>
                </InspectorControls>
                <div className={`prodigy-${attributes.display}-columns-${attributes.columns}`}>
                    {attributes.display === 'slider' && !loading && (
                        <div className="prodigy-slider-arrow prodigy-slider-arrow-left"><Dashicon icon="arrow-left-alt2" /></div>
                    )}
                    <ServerSideRender
                        block="prodigy/products"
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

export default productsBlock;