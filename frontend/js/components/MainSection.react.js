var React = require('react');
var ReactPropTypes = React.PropTypes;
var TimelogItem = require('./TimelogItem.react');

var MainSection = React.createClass({

  propTypes: {
    allTimelogs: ReactPropTypes.object.isRequired
  },

  render: function() {
    
    var allTimelogs = this.props.allTimelogs;
    var timelogs = [];

    for (var key in allTimelogs) {
      timelogs.push(<TimelogItem key={key} timelog={allTimelogs[key]} />);
    }

    timelogs.reverse();

  	return (
      <section id="main">
        <ul id="todo-list" className="list-group">{timelogs}</ul>
      </section>
    );
  }


});

module.exports = MainSection;