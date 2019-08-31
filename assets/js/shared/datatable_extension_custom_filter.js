/**
 * Extending the datable animal for the custom filter for edad en meses.
 */
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = parseInt( $('#min_old').val(), 10 );
        var max = parseInt( $('#max_old').val(), 10 );
        var age = parseFloat( data[4] ) || 0; // use data for the old in months column

        if ( ( isNaN( min ) && isNaN( max ) ) ||
            ( isNaN( min ) && age <= max ) ||
            ( min <= age   && isNaN( max ) ) ||
            ( min <= age   && age <= max ) )
        {
            return true;
        }
        return false;
    }
);