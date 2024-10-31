import { PanelBody, QueryControls, SelectControl, ToggleControl } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { withSelect } from '@wordpress/data';
import { categoryIcon } from '../icons';

const categoryBlock = {
    title: 'Prodigy Category',
    icon: categoryIcon,
    category: 'prodigy',

    // Block attributes.
    attributes: {
        idWidget: {
            type: 'string',
            default: '',
        },
        category_id: {
            type: 'string',
            default: '',
        },
        show_product_count: {
            type: 'boolean',
            default: true
        }
    },

    edit: withSelect((select) => {
        const { getEntityRecords } = select('core');
        const categories = getEntityRecords('taxonomy', 'prodigy-product-category', { per_page: -1 });

        return { categories };
    })(({ categories, attributes, setAttributes }) => {
        console.log(categories)
        const onChange = (attribute, value) => {
            setAttributes({[attribute]: value});
        };

        return (
            <div>
                <InspectorControls>
                    <PanelBody title="Category Selection">
                        {categories && (
                            <QueryControls
                                label="Category"
                                categoriesList={categories}
                                onCategoryChange={(categoryId) => onChange('category_id', categories.find(cat => cat.id === parseInt(categoryId))?.prodigyHostedCategoryRelation)}
                                selectedCategoryId={categories.find(cat => cat.prodigyHostedCategoryRelation === attributes.category_id)?.id}
                                maxItems={-1}
                            />
                        )}
                    </PanelBody>
                    <PanelBody title="Category Display">
                        <ToggleControl
                            label="Product Count"
                            checked={attributes.show_product_count}
                            onChange={(value) => onChange('show_product_count', value)}
                        />
                    </PanelBody>
                </InspectorControls>
                <ServerSideRender
                    block="prodigy/category"
                    attributes={attributes}
                />
            </div>
        );
    }),
    save: () => null,
};

export default categoryBlock;