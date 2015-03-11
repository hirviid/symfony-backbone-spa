var React = require('react');
var ReactPropTypes = React.PropTypes;
var moment = require('moment');

var TimelogItem = React.createClass({

  propTypes: {
   timelog: ReactPropTypes.object.isRequired
  },

  render: function() {
    var timelog = this.props.timelog;
    var start = moment(timelog.start, 'X');
    var end = moment(timelog.end, 'X');
    var startDay = start.format('DD-MM-YYYY');
    var startTime = start.format('HH:mm');
    var endTime = end.format('HH:mm');
    var difference = end.subtract(start).format('HH:mm');

    return (
    	<li className="list-group-item row">
        <span className="col-sm-8">{startDay} - {timelog.description}</span>
        <span className="col-sm-2">{startTime} - {endTime}</span>
    		<span className="col-sm-2">{difference}</span>
    	</li>
    );
  }

});

module.exports = TimelogItem;