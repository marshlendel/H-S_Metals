import { sortRows, cmpCust, cmpDate, cmpStatus, cmpNum } from './scripts.js';
import { createRequire } from 'module';
var require = createRequire(import.meta.url);
var assert = require('assert');
describe('Array', function() {
    var array = [{'customer':'Banana', 'date':'2020-08-17', 'status':'DIRTY','lotnum':5},
                 {'customer':'Apple', 'date':'2020-09-17', 'status':'CLEAN','lotnum':10},
                 {'customer':'Cantalope', 'date':'2020-08-20', 'status':'FINISHED','lotnum':1}];
    describe('#sortRowsAscending()', function() {
        it('should sort the array of arrays by customer', function() {
            let toSort = array.slice();
            sortRows(toSort, 'customer', false);
            for (var i = 0; i < toSort.length-1; i++) {
                assert.equal(toSort[i]['customer'] < toSort[i+1]['customer'], true);
            }
        });
        it('should sort the array of arrays by date', function() {
            let toSort = array.slice();
            sortRows(toSort, 'date', false);
            for (var i = 0; i < toSort.length-1; i++) {
                assert.equal(toSort[i]['date'] < toSort[i+1]['date'], true);
            }
        });
        it('should sort the array of arrays by status', function() {
            let toSort = array.slice();
            sortRows(toSort, 'status', false);
            for (var i = 0; i < toSort.length-1; i++) {
                assert.equal(toSort[i]['status'] < toSort[i+1]['status'], true);
            }
        });
        it('should sort the array of arrays by lot number', function() {
            let toSort = array.slice();
            sortRows(toSort, 'lotnum', false);
            for (var i = 0; i < toSort.length-1; i++) {
                assert.equal(toSort[i]['lotnum'] < toSort[i+1]['lotnum'], true);
            }
        });
    });
    describe('#sortRowsDescending()', function() {
        it('should sort the array of arrays by customer', function() {
            let toSort = array.slice();
            sortRows(toSort, 'customer', true);
            for (var i = 0; i < toSort.length-1; i++) {
                assert.equal(toSort[i]['customer'] > toSort[i+1]['customer'], true);
            }
        });
        it('should sort the array of arrays by date', function() {
            let toSort = array.slice();
            sortRows(toSort, 'date', true);
            for (var i = 0; i < toSort.length-1; i++) {
                assert.equal(toSort[i]['date'] > toSort[i+1]['date'], true);
            }
        });
        it('should sort the array of arrays by status', function() {
            let toSort = array.slice();
            sortRows(toSort, 'status', true);
            for (var i = 0; i < toSort.length-1; i++) {
                assert.equal(toSort[i]['status'] > toSort[i+1]['status'], true);
            }
        });
        it('should sort the array of arrays by lot number', function() {
            let toSort = array.slice();
            sortRows(toSort, 'lotnum', true);
            for (var i = 0; i < toSort.length-1; i++) {
                assert.equal(toSort[i]['lotnum'] > toSort[i+1]['lotnum'], true);
            }
        });
    });
});
