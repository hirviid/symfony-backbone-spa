var React = require('react');
var Header = require('./Header.react');

var App = React.createClass({

  /**
   * @return {object}
   */
  render: function() {
  	return (
      <div className="container">
        <Header />
      </div>
  	);
  },

});

module.exports = App;