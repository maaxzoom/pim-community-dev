import thunkMiddleware from 'redux-thunk';
import {applyMiddleware, createStore} from 'redux';
import ProductInterface from 'pimfront/product/domain/model/product';
import routerMiddleware from 'pimfront/tools/router-middleware';
import gridReducer, {State} from 'pimfront/product-grid/application/reducer/main';
const router = require('pim/router');
import logger from 'redux-logger';

export type GlobalState = State<ProductInterface>;

export default createStore<GlobalState>(
  gridReducer,
  applyMiddleware(thunkMiddleware, routerMiddleware(router), logger)
);
