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

var TimelogTextInput = React.createClass({

  propTypes: {
    className: ReactPropTypes.string,
    id: ReactPropTypes.string,
    placeholder: ReactPropTypes.string,
    onSave: ReactPropTypes.func.isRequired,
    value: ReactPropTypes.string
  },

  getInitialState: function() {
    return {
      value: this.props.value || ''
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
    var now = moment(); console.log(now);

    return (
      <div className="row form-group">
        <div className="col-sm-5">
            <input
              className={classStr}
              id={this.props.id}
              placeholder={this.props.placeholder}
              onBlur={this._save}
              onChange={this._onChange}
              onKeyDown={this._onKeyDown}
              value={this.state.value}
              autoFocus={true}
            />
        </div>
        <div className="col-sm-2">
            <DateTimeField 
              dateTime={now}
              inputFormat="DD/MM/YY H:mm"
            />
        </div>        
        <div className="col-sm-2">
            <DateTimeField 
              dateTime={now}
              inputFormat="DD/MM/YY H:mm"
            />
        </div>
        <div className="col-sm-3">
            <button className="btn btn-primary">Save</button>
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

});

module.exports = TimelogTextInput;
