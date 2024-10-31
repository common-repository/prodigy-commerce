import { registerBlockType } from '@wordpress/blocks';
import productsBlock from './products';
import categoriesBlock from './categories';
import categoryBlock from './category';

registerBlockType('prodigy/products', productsBlock);
registerBlockType('prodigy/categories', categoriesBlock);
registerBlockType('prodigy/category', categoryBlock);