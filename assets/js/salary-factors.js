'use strict';

import '../css/salary-factors.scss';

import $ from 'jquery';
import doT from 'dot/doT';
import 'jQuery-QueryBuilder/dist/js/query-builder.standalone.js';
import 'jQuery-QueryBuilder/dist/css/query-builder.default.css';

$(() => {
    $('.js-salary_factor.js-querybuilder').queryBuilder({
        filters: [{
            id: 'tags',
            label: 'Tags',
            type: 'string',
            operators: ['equal', 'not_equal', 'in', 'not_in']
        }]
    });

    $('#builder').queryBuilder({
        filters: [{
            id: 'tags',
            label: 'Tags',
            type: 'string',
            operators: ['equal', 'not_equal', 'in', 'not_in']
        }]
    });
})
