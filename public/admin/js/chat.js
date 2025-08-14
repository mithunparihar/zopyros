function revenueChart() {
    const response = ajaxUrl(revenueChartURL, "POST", {
        _token: $("meta[name=csrf-token]").attr("content"),
    });
    let o, r, e, t, s, i;
    response.done(function (res) {
        var a = document.querySelector("#revenueChart"),
            n = {
                chart: {
                    height: 74,
                    type: "bar",
                    toolbar: { show: !1 },
                    // sparkline: { enabled: true },
                },
                plotOptions: {
                    bar: {
                        barHeight: "80%",
                        columnWidth: "75%",
                        startingShape: "rounded",
                        endingShape: "rounded",
                        borderRadius: 2,
                        distributed: !0,
                    },
                },
                grid: {
                    show: !1,
                    padding: { top: -20, bottom: -12, left: -10, right: 0 },
                },
                colors: [
                    config.colors.primary,
                    config.colors.primary,
                    config.colors.primary,
                    config.colors.primary,
                    config.colors.primary,
                    config.colors.primary,
                    config.colors.primary,
                ],
                dataLabels: { enabled: !1 },
                series: [{ data: res?.results }],
                legend: { show: !1 },
                xaxis: {
                    categories: ["S", "M", "T", "W", "T", "F", "S"],
                    axisBorder: { show: !1 },
                    axisTicks: { show: !1 },
                    labels: { style: { colors: t, fontSize: "13px" } },
                },
                yaxis: { labels: { show: !1 } },
                tooltip: {
                    custom: function ({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w,
                    }) {
                        var data =
                            w.globals.initialSeries[seriesIndex].data[
                                dataPointIndex
                            ];
                        var dayName = [
                            "SUNDAY",
                            "MONDAY",
                            "TUESDAY",
                            "WEDNESDAY",
                            "THURSDAY",
                            "FRIDAY",
                            "SATURDAY",
                        ];
                        var day = dayName[dataPointIndex];
                        return (
                            "<div class='border flex-row p-2  py-1 small'><strong>" +
                            day +
                            " : </strong> " +
                            data +
                            "</div>"
                        );
                    },
                },
            };
        null !== a && new ApexCharts(a, n).render();
    });
    response.fail(function () {
        alert("fail revenueChart");
    });
}
function feedbackChart() {
    const response = ajaxUrl(feedbackChartURL, "POST", {
        _token: $("meta[name=csrf-token]").attr("content"),
    });
    let o, r, e, t, s, i;
    response.done(function (res) {
        var a = document.querySelector("#feedbackChart"),
            n = {
                chart: {
                    height: 80,
                    type: "area",
                    toolbar: { show: !1 },
                    sparkline: { enabled: !0 },
                },
                markers: {
                    size: 6,
                    colors: "transparent",
                    strokeColors: "transparent",
                    strokeWidth: 4,
                    discrete: [
                        {
                            fillColor: config.colors.white,
                            seriesIndex: 0,
                            dataPointIndex: 6,
                            strokeColor: config.colors.info,
                            strokeWidth: 2,
                            size: 6,
                            radius: 8,
                        },
                    ],
                    hover: { size: 7 },
                },
                grid: { show: !1, padding: { right: 8 } },
                colors: [config.colors.info],
                fill: {
                    type: "gradient",
                    gradient: {
                        shade: s,
                        shadeIntensity: 0.8,
                        opacityFrom: 0.8,
                        opacityTo: 0.25,
                        stops: [0, 85, 100],
                    },
                },
                dataLabels: { enabled: !1 },
                stroke: { width: 2, curve: "smooth" },
                series: [{ data: res?.results }],
                xaxis: {
                    categories: [
                        "SUNDAY",
                        "MONDAY",
                        "TUESDAY",
                        "WEDNESDAY",
                        "THURSDAY",
                        "FRIDAY",
                        "SATURDAY",
                    ],
                    show: !1,
                    lines: { show: !1 },
                    labels: { show: !1 },
                    stroke: { width: 0 },
                    axisBorder: { show: !1 },
                },
                yaxis: { stroke: { width: 0 }, show: !1 },
                tooltip: {
                    custom: function ({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w,
                    }) {
                        var data =
                            w.globals.initialSeries[seriesIndex].data[
                                dataPointIndex
                            ];
                        var dayName = [
                            "SUNDAY",
                            "MONDAY",
                            "TUESDAY",
                            "WEDNESDAY",
                            "THURSDAY",
                            "FRIDAY",
                            "SATURDAY",
                        ];
                        var day = dayName[dataPointIndex];
                        return (
                            "<div class='border flex-row p-2  py-1 small'><strong>" +
                            day +
                            " : </strong> " +
                            data +
                            "</div>"
                        );
                    },
                },
            };
        null !== a && new ApexCharts(a, n).render();
    });
    response.fail(function () {
        alert("fail revenueChart");
    });
}
function deleResChart() {
    const response = ajaxUrl(deleResChartURL, "POST", {
        _token: $("meta[name=csrf-token]").attr("content"),
    });
    let o, r, e, t, s, i;
    response.done(function (res) {
        var a = document.querySelector("#deleresChart"),
            n = {
                chart: { height: 66, type: "bar", toolbar: { show: !1 } },
                plotOptions: {
                    bar: {
                        barHeight: "80%",
                        columnWidth: "75%",
                        startingShape: "rounded",
                        endingShape: "rounded",
                        borderRadius: 2,
                        distributed: !0,
                    },
                },
                grid: {
                    show: !1,
                    padding: { top: -20, bottom: -12, left: -10, right: 0 },
                },
                colors: [
                    config.colors.dark,
                    config.colors.dark,
                    config.colors.dark,
                    config.colors.dark,
                    config.colors.dark,
                    config.colors.dark,
                    config.colors.dark,
                ],
                dataLabels: { enabled: !1 },
                series: [{ data: res?.results }],
                legend: { show: !1 },
                xaxis: {
                    categories: ["S", "M", "T", "W", "T", "F", "S"],
                    axisBorder: { show: !1 },
                    axisTicks: { show: !1 },
                    labels: { style: { colors: t, fontSize: "13px" } },
                },
                yaxis: { labels: { show: !1 } },
                tooltip: {
                    custom: function ({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w,
                    }) {
                        var data =
                            w.globals.initialSeries[seriesIndex].data[
                                dataPointIndex
                            ];
                        var dayName = [
                            "SUNDAY",
                            "MONDAY",
                            "TUESDAY",
                            "WEDNESDAY",
                            "THURSDAY",
                            "FRIDAY",
                            "SATURDAY",
                        ];
                        var day = dayName[dataPointIndex];
                        return (
                            "<div class='border flex-row p-2  py-1 small'><strong>" +
                            day +
                            " : </strong> " +
                            data +
                            "</div>"
                        );
                    },
                },
            };
        null !== a && new ApexCharts(a, n).render();
    });
    response.fail(function () {
        alert("fail revenueChart");
    });
}
function OrderChat() {
    const response = ajaxUrl(orderChartURL, "POST", {
        _token: $("meta[name=csrf-token]").attr("content"),
    });
    let o, r, e, t, s, i;
    response.done(function (res) {
        var a = document.querySelector("#orderChart"),
            n = {
                chart: {
                    height: 80,
                    type: "area",
                    toolbar: { show: !1 },
                    sparkline: { enabled: !0 },
                },
                markers: {
                    size: 6,
                    colors: "transparent",
                    strokeColors: "transparent",
                    strokeWidth: 4,
                    discrete: [
                        {
                            fillColor: config.colors.white,
                            seriesIndex: 0,
                            dataPointIndex: 6,
                            strokeColor: config.colors.success,
                            strokeWidth: 2,
                            size: 6,
                            radius: 8,
                        },
                    ],
                    hover: { size: 7 },
                },
                grid: { show: !1, padding: { right: 8 } },
                colors: [config.colors.success],
                fill: {
                    type: "gradient",
                    gradient: {
                        shade: s,
                        shadeIntensity: 0.8,
                        opacityFrom: 0.8,
                        opacityTo: 0.25,
                        stops: [0, 85, 100],
                    },
                },
                dataLabels: { enabled: !1 },
                stroke: { width: 2, curve: "smooth" },
                series: [{ data: res?.results }],
                xaxis: {
                    categories: [
                        "SUNDAY",
                        "MONDAY",
                        "TUESDAY",
                        "WEDNESDAY",
                        "THURSDAY",
                        "FRIDAY",
                        "SATURDAY",
                    ],
                    show: !1,
                    lines: { show: !1 },
                    labels: { show: !1 },
                    stroke: { width: 0 },
                    axisBorder: { show: !1 },
                },
                yaxis: { stroke: { width: 0 }, show: !1 },
                tooltip: {
                    custom: function ({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w,
                    }) {
                        var data =
                            w.globals.initialSeries[seriesIndex].data[
                                dataPointIndex
                            ];
                        var dayName = [
                            "SUNDAY",
                            "MONDAY",
                            "TUESDAY",
                            "WEDNESDAY",
                            "THURSDAY",
                            "FRIDAY",
                            "SATURDAY",
                        ];
                        var day = dayName[dataPointIndex];
                        return (
                            "<div class='border flex-row p-2  py-1 small'><strong>" +
                            day +
                            " : </strong> " +
                            data +
                            "</div>"
                        );
                    },
                },
            };
        null !== a && new ApexCharts(a, n).render();
    });
    response.fail(function () {
        alert("fail revenueChart");
    });
}
function profileReportChart() {
    const response = ajaxUrl(profileReportChartURL, "POST", {
        _token: $("meta[name=csrf-token]").attr("content"),
    });
    let o, r, e, t, s, i;
    response.done(function (res) {
        var a = document.querySelector("#profileReportChart"),
            n = {
                chart: {
                    height: 80,
                    type: "line",
                    toolbar: { show: !1 },
                    dropShadow: {
                        enabled: !0,
                        top: 10,
                        left: 5,
                        blur: 3,
                        color: config.colors.warning,
                        opacity: 0.15,
                    },
                    sparkline: { enabled: !0 },
                },
                grid: { show: !1, padding: { right: 8 } },
                colors: [config.colors.warning],
                dataLabels: { enabled: !1 },
                stroke: { width: 5, curve: "smooth" },
                series: [{ data: res?.results }],
                xaxis: {
                    categories: [
                        "JAN",
                        "FEB",
                        "MAR",
                        "APR",
                        "MAY",
                        "JUN",
                        "JUL",
                        "AUG",
                        "SEP",
                        "OCT",
                        "NOV",
                        "DEC",
                    ],
                    show: !1,
                    lines: { show: !1 },
                    labels: { show: !1 },
                    axisBorder: { show: !1 },
                    
                },
                yaxis: { show: !1 },
                tooltip: {
                    custom: function ({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w,
                    }) {
                        var data =
                            w.globals.initialSeries[seriesIndex].data[
                                dataPointIndex
                            ];
                        var dayName = [
                            "SUNDAY",
                            "MONDAY",
                            "TUESDAY",
                            "WEDNESDAY",
                            "THURSDAY",
                            "FRIDAY",
                            "SATURDAY",
                        ];
                        var day = dayName[dataPointIndex];
                        if(day!=undefined){
                            return (
                                "<div class='border flex-row p-2  py-1 small'><strong>" +
                                day +
                                " : </strong> " +
                                data +
                                "</div>"
                            );
                        }else{
                            return ('');
                        }
                    },
                },
            };
        null !== a && new ApexCharts(a, n).render();
    });
    response.fail(function () {
        alert("fail revenueChart");
    });
}
function profileDeletedChart() {
    const response = ajaxUrl(profileDeletedChartURL, "POST", {
        _token: $("meta[name=csrf-token]").attr("content"),
    });
    let o, r, e, t, s, i;
    response.done(function (res) {
        var a = document.querySelector("#profileDeletedChart"),
            n = {
                chart: {
                    height: 80,
                    type: "line",
                    toolbar: { show: !1 },
                    dropShadow: {
                        enabled: !0,
                        top: 10,
                        left: 5,
                        blur: 3,
                        color: config.colors.danger,
                        opacity: 0.15,
                    },
                    sparkline: { enabled: !0 },
                },
                grid: { show: !1, padding: { right: 8 } },
                colors: [config.colors.danger],
                dataLabels: { enabled: !1 },
                stroke: { width: 5, curve: "smooth" },
                series: [{ data: res?.results }],
                xaxis: {
                    categories: [
                        "JAN",
                        "FEB",
                        "MAR",
                        "APR",
                        "MAY",
                        "JUN",
                        "JUL",
                        "AUG",
                        "SEP",
                        "OCT",
                        "NOV",
                        "DEC",
                    ],
                    show: !1,
                    lines: { show: !1 },
                    labels: { show: !1 },
                    axisBorder: { show: !1 },
                },
                yaxis: { show: !1 },
                tooltip: {
                    custom: function ({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w,
                    }) {
                        var data =
                            w.globals.initialSeries[seriesIndex].data[
                                dataPointIndex
                            ];
                        var dayName = [
                            "SUNDAY",
                            "MONDAY",
                            "TUESDAY",
                            "WEDNESDAY",
                            "THURSDAY",
                            "FRIDAY",
                            "SATURDAY",
                        ];
                        var day = dayName[dataPointIndex];
                        if(day!=undefined){
                            return (
                                "<div class='border flex-row p-2  py-1 small'><strong>" +
                                day +
                                " : </strong> " +
                                data +
                                "</div>"
                            );
                        }else{
                            return ('');
                        }
                        
                    },
                },
            };
        null !== a && new ApexCharts(a, n).render();
    });
    response.fail(function () {
        alert("fail revenueChart");
    });
}
