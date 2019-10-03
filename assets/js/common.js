require('../css/common.scss');

var $ = require('jquery');
console.log('common.js<<<<');

//const logoPath = require('../img/logo.png');

const doT = require('dot');
const QueryBuilder = require('jQuery-QueryBuilder');

$(document).ready(function() {
    console.log('document ready >>>>>>>>');
    $('.js-salary_factor.js-querybuilder').queryBuilder({
        filters: [{
            id: 'tags',
            label: 'Tags',
            type: 'string',
            operators: ['equal', 'not_equal', 'in', 'not_in']
        }]
    });
});
