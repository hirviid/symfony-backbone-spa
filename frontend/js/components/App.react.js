var React = require('react');
var Header = require('./Header.react');
var MainSection = require('./MainSection.react');
var TimelogStore = require('../stores/TimelogStore');

function getTimelogState() {
  console.log(TimelogStore.getAll());
  return {
    allTimelogs: TimelogStore.getAll()
  };
}

var App = React.createClass({

  getInitialState: function() {
    return getTimelogState();
  },

  componentDidMount: function() {
    TimelogStore.addChangeListener(this._onChange);
  },

  componentWillUnmount: function() {
    TimelogStore.removeChangeListener(this._onChange);
  },

  /**
   * @return {object}
   */
  render: function() {
  	return (
      <div className="container">
        <Header />
        <MainSection
          allTimelogs={this.state.allTimelogs}
        />
      </div>
  	);
  },

  _onChange: function() {
    this.setState(getTimelogState());
  }

});

module.exports = App;