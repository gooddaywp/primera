/** Primera theme */

// import './vendor/fitvids';
// import _ from './_lodash';
import { $, $win, $doc, wp, vh, vw, fromTop } from './_globals';
import tw from '../../tailwind.config.js';
// import util from './utils';

const app = {

    init: () => {
        app.cacheProps();
        app.bindEvents();
    },

    cacheProps: () => {
    },

    bindEvents: () => {
        $doc.on('click', app.doSomething);
    },

    doSomething: e => {
        e.preventDefault();
        console.log(app);
    }
};

app.init();


