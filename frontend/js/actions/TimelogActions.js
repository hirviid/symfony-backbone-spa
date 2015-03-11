var AppDispatcher = require('../dispatcher/AppDispatcher');
var TimelogConstants = require('../constants/TimelogConstants');

var TimelogActions = {

  /**
   * @param  {string} text
   * @param  {string} start
   * @param  {string} end
   */
  create: function(description, start, end) {
    AppDispatcher.dispatch({
      actionType: TimelogConstants.TIMELOG_CREATE,
      description: description,
      start: start,
      end: end
    });
  }

};

module.exports = TimelogActions;