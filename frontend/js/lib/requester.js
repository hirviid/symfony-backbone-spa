(function() {

	window.request = function (params) {
            var defer = $.Deferred();

            params.method = params.method || 'GET';

            $.ajax(params.url, {
                method: params.method,
                data: params.data || null,
                //global: _.isUndefined(params.global) ? true : params.global,
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                //processData: params.method === 'GET',
                success: params.success || function () {},
                /*beforeSend: function (jqXHR, settings) {
                    if (settings.data) {
                        settings.data = JSON.stringify(settings.data);
                    }
                }*/
            })
                .done(function (response) {
                    if (params.done) {
                        response = params.done(response);
                    }

                    defer.resolve(response);
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseText) {
                        try {
                            var parsedResponse = JSON.parse(jqXHR.responseText);
                            if (parsedResponse.responseStatus) {
                                defer.reject(parsedResponse.responseStatus);
                            } else {
                                throw false;
                            }
                        } catch (e) {
                            defer.reject({});
                        }

                    }
                });

            return defer.promise();
        }

})();