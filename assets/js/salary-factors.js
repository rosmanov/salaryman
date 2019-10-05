'use strict';

import '../css/salary-factors.scss';

import $ from 'jquery';
import doT from 'dot/doT'; // required by jQuery-QueryBuilder
import 'jQuery-QueryBuilder/dist/js/query-builder.standalone.js';
import 'jQuery-QueryBuilder/dist/css/query-builder.default.css';

$(() => {
    $('.js-querybuilder').each(function () {
        const empty_rules =  {
            condition: 'AND',
            rules: [
                {},
                { empty: true }
            ]
        };
        const integerOperators = ['equal', 'not_equal', 'less', 'less_or_equal',
            'greater', 'greater_or_equal'];
        const integerRe = /^\d+$/;

        let self = $(this);
        let $target = $('#' + $(self).data('targetId'));

        $(this).closest('form').on('submit', function () {
            let result = $(self).queryBuilder('getRules');

            if (!$.isEmptyObject(result) && $target) {
                $target.val(JSON.stringify(result));
            }
        })

        let rules = $(self).data('rules') || {};
        if (typeof rules === 'string') {
            rules = JSON.parse(rules);
        }
        if ($.isEmptyObject(rules)) {
            rules = empty_rules;
        }

        const filters = [
            {
                id: 'age',
                label: 'Age',
                type: 'integer',
                validation: {
                    format: integerRe,
                    min: 18,
                    max: 255,
                    step: 1,
                    messages: {
                        format: 'The provided age is out of range 18..255'
                    },
                    allow_empty_value: false
                },
                operators: integerOperators
            },
            {
                id: 'kids',
                label: 'Kids',
                type: 'integer',
                placeholder: 'The number of kids',
                validation: {
                    format: integerRe,
                    min: 0,
                    max: 100,
                    step: 1,
                    messages: {
                        format: 'The provided number of kids must be an integer in range 0..100'
                    }
                },
                operators: integerOperators,
                default_value: 0
            },
            {
                id: 'using_company_car',
                label: 'Using Company Car',
                type: 'integer',
                input: 'radio',
                default_value: 0,
                values: [
                    { value: 1, label: 'Yes' },
                    { value: 0, label: 'No' }
                ],
                operators: ['equal']
            }
        ];

        $(this).queryBuilder({
            filters: filters,
            rules: rules
        });
    });
});
