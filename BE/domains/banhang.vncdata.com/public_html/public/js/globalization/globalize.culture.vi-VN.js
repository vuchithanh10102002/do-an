!function (a, b) {
    var c;
    c = "undefined" != typeof require && "undefined" != typeof exports && "undefined" != typeof module ? require("globalize") : a.Globalize, c.addCultureInfo("vi-VN", "default", {
        name: "vi",
        englishName: "VietNam",
        nativeName: "VietNam",
        isRTL: !1,
        language: "vi",
        numberFormat: {
            pattern: ["-n"],
            decimals: 2,
            ",": ",",
            ".": ".",
            groupSizes: [3],
            "+": "+",
            "-": "-",
            NaN: "NaN",
            negativeInfinity: "-Infinity",
            positiveInfinity: "Infinity",
            percent: {pattern: ["-n %", "n %"], decimals: 2, groupSizes: [3], ",": ",", ".": ".", symbol: "%"},
            currency: {pattern: ["($n)", "$n"], decimals: 2, groupSizes: [3], ",": ",", ".": ".", symbol: "$"}
        },
        calendars: {
            standard: {
                name: "Gregorian_VietNam",
                "/": "/",
                ":": ":",
                firstDay: 0,
                days: {
                    names: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                    namesAbbr: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                    namesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"]
                },
                months: {
                    names: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", ""],
                    namesAbbr: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", ""]
                },
                AM: ["AM", "am", "AM"],
                PM: ["PM", "pm", "PM"],
                eras: [{name: "A.D.", start: null, offset: 0}],
                twoDigitYearMax: 2029,
                patterns: {
                    d: "M/d/yyyy",
                    D: "dddd, MMMM dd, yyyy",
                    t: "h:mm tt",
                    T: "h:mm:ss tt",
                    f: "dddd, MMMM dd, yyyy h:mm tt",
                    F: "dddd, MMMM dd, yyyy h:mm:ss tt",
                    M: "MMMM dd",
                    Y: "yyyy MMMM",
                    S: "yyyy'-'MM'-'dd'T'HH':'mm':'ss"
                }
            }
        }
    })
}(this);