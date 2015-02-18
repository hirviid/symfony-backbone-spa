var React = require('react');
var TimelogTextInput = require('./TimelogTextInput.react');

var Header = React.createClass({

  /**
   * @return {object}
   */
  render: function() {
    return (
      <header id="header">
        <TimelogTextInput
          id="new-timelog"
          placeholder="What are you working on?"
          onSave={this._onSave}
        />
      </header>
    );
  },

  /**
   * Event handler called within TodoTextInput.
   * Defining this here allows TodoTextInput to be used in multiple places
   * in different ways.
   * @param {string} text
   */
  _onSave: function(text) {
    // if (text.trim()){
      // TodoActions.create(text);
    // }

  }

});

module.exports = Header;