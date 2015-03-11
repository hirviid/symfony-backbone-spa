/**
 * Copyright (c) 2014, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree. An additional grant
 * of patent rights can be found in the PATENTS file in the same directory.
 */

var React = require('react');
var ReactPropTypes = React.PropTypes;
var DateTimeField = require('react-bootstrap-datetimepicker');
var moment = require('moment');

var ENTER_KEY_CODE = 13;
var now = moment().format('X');

var TimelogTextInput = React.createClass({

  propTypes: {
    className: ReactPropTypes.string,
    id: ReactPropTypes.string,
    placeholder: ReactPropTypes.string,
    onSave: ReactPropTypes.func.isRequired,
    value: ReactPropTypes.string,
    start: ReactPropTypes.string,
    end: ReactPropTypes.string,
    startDate: ReactPropTypes.string,
    startTime: ReactPropTypes.string,
    endTime: ReactPropTypes.string
  },

  getInitialState: function() {
    return {
      value: this.props.value || '',
      start: this.props.start || now,
      end: this.props.end || now,
      startDate: moment(this.props.start || now, 'X').format('DD-MM-YYYY'),
      startTime: moment(this.props.start || now, 'X').format('HH:mm'),
      endTime: moment(this.props.end || now, 'X').format('HH:mm')
    };
  },

  /**
   * @return {object}
   */
  render: function() /*object*/ {
    /*var cx = React.addons.classSet;
    var classes = cx({
      'form-control': true
    });*/

    var classStr = (this.props.className || '') + ' form-control';
    // var startDate = moment(this.state.start, 'X').format('DD-MM-YYYY');
    // var startTime = moment(this.state.end, 'X').format('HH:mm');
    // var endTime = startTime;

    return (
      <div className="row form-group">
        <div className="col-sm-2">
            <input className={classStr} value={this.state.startDate} onChange={this._onChangeStart} />
        </div>
        <div className="col-sm-4">
            <input
              className={classStr}
              id={this.props.id}
              placeholder={this.props.placeholder}
              // onBlur={this._save}
              onChange={this._onChange}
              // onKeyDown={this._onKeyDown}
              value={this.state.value}
              autoFocus={true}
            />
        </div>
        <div className="col-sm-2">
            <input className={classStr} value={this.state.startTime} onChange={this._onChangeStartTime} />
        </div>
        <div className="col-sm-2">
            <input className={classStr} value={this.state.endTime}  onChange={this._onChangeEndTime}/>
        </div>
        <div className="col-sm-2">
            <button className="btn btn-primary" onClick={this._save}>Save</button>
        </div>
      </div>
    );
  },

  /**
  * @param {object} event
  */
  _onChange: function(/*object*/ event) {
    this.setState({
      value: event.target.value
    });
  },

  _onChangeStart: function(/*object*/ event) {
    this.setState({
      startDate: event.target.value
    });
  },

  _onChangeStartTime: function(/*object*/ event) {
    this.setState({
      startTime: event.target.value
    });
  },

  _onChangeEndTime: function(/*object*/ event) {
    this.setState({
      endTime: event.target.value
    });
  },

  _save: function() {
    var s = moment(this.state.startDate + this.state.startTime, 'DD-MM-YYYYHH:mm').format('X');
    var e = moment(this.state.startDate + this.state.endTime, 'DD-MM-YYYYHH:mm').format('X');

    this.setState({
      start: s,
      end: e
    });

    this.props.onSave(this.state.value, s, e);
  }

});

module.exports = TimelogTextInput;
