'use strict';

import '../css/salary-factors.scss';

import $ from 'jquery';
import doT from 'dot/doT';
import 'jQuery-QueryBuilder/dist/js/query-builder.standalone.js';
import 'jQuery-QueryBuilder/dist/css/query-builder.default.css';

$(() => {
    $('.js-querybuilder').each(function () {
        let self = $(this);
        let $target = $('#' + $(self).data('targetId'));

        $(self).queryBuilder({
            filters: [{
                id: 'tags',
                label: 'Tags',
                type: 'string',
                operators: ['equal', 'not_equal', 'in', 'not_in']
            }],
            rules: $(self).data('rules')
        });

        $(self).closest('form').on('submit', function () {
            let result = $(self).queryBuilder('getRules');

            if (!$.isEmptyObject(result) && $target) {
                $target.val(JSON.stringify(result));
            }
        })
    });
})
