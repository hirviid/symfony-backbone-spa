var AppDispatcher = require('../dispatcher/AppDispatcher');
var EventEmitter = require('events').EventEmitter;
var TimelogConstants = require('../constants/TimelogConstants');
var assign = require('object-assign');

var CHANGE_EVENT = 'change';

var _timelogs = {};

function create(description, start, end) {
  var id = (+new Date() + Math.floor(Math.random() * 999999)).toString(36);
  _timelogs[id] = {
    id: id,
    description: description,
    start: start,
    end: end
  };
}

var TimelogStore = assign({}, EventEmitter.prototype, {
	emitChange: function() {
	    this.emit(CHANGE_EVENT);
  	},

  	getAll: function() {
    	return _timelogs;
  	},

  /**
   * @param {function} callback
   */
  	addChangeListener: function(callback) {
    	this.on(CHANGE_EVENT, callback);
  	},

   /**
   	* @param {function} callback
   	*/
  	removeChangeListener: function(callback) {
    	this.removeListener(CHANGE_EVENT, callback);
  	}
});


AppDispatcher.register(function(action) {
	switch(action.actionType) {
		case TimelogConstants.TIMELOG_CREATE:
			create(action.description, action.start, action.end);
			TimelogStore.emitChange();
  		default:
      	// no op
  	}
});

module.exports = TimelogStore;