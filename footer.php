<a href="javaScript:;" class="back-to-top">
    <i class='bx bxs-up-arrow-alt'></i>
</a>
<!--End Back To Top Button-->
<footer class="page-footer">
    <p class="mb-0">Copyright ©
        <?= date('Y') ?> आदित्य नर्सरी द्वारे <a href="/" target="_blank" class="text-muted fw-bold">पार्ष इन्फोटेक
            प्रा.
            ली</a>.
    </p>
</footer>
</div>
<!--start switcher-->
<div class="switcher-wrapper my-auto">
    <div class="switcher-btn"> <i class='bx bx-sun bx-spin'></i>
    </div>
    <div class="switcher-body">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 text-uppercase">Change Themes</h5>
            <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
        </div>
        <hr />
        <div class="d-flex align-items-center justify-content-around">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode">
                <label class="form-check-label" for="lightmode">Light</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
                <label class="form-check-label" for="darkmode">Dark</label>
            </div>
            <!--<div class="form-check">-->
            <!--	<input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark" checked>-->
            <!--	<label class="form-check-label" for="semidark">Semi Dark</label>-->
            <!--</div>-->
        </div>
    </div>
</div>
<!--end switcher-->
<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/moment.js"></script>
<script src="assets/js/flatpickr.min.js"></script>
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/js/vfs_fonts.js"></script>
<script>
    $(document).ready(() => {
        // ping notifications every 10 seconds
        setInterval(() => {
            $.ajax({
                url: 'ajax_notification',
                method: 'GET',
                data: {
                    ping_notification: true
                }
            })
        }, 10000);
        const notifyContainer = $('.notifications-list');
        $.ajax({
            url: 'ajax_notification',
            method: 'GET',
            data: {
                get_notifications: true,
                page: 1,
                limit: 50,
            },
            success: res => {
                const notif = res.data;
                notifyContainer.empty();
                if (res.count) {
                    $('.notify-counter').text(res.count);
                    notif.forEach(alert => {
                        const notification = $(`<div class="d-flex gap-2 align-items-top px-3 py-2 border-bottom position-relative notification-item">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle text-primary bg-primary bg-opacity-25" style="width: 40px;height: 40px;">
                                                <i class="bx bx-bell fs-5"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold">${alert.notify_title}</div>
                                                <div class="small">${alert.notify_desc}</div>
                                            </div>
                                        </div>`);
                        notification.find('a').on('click', function (e) {
                            e.preventDefault();
                            $.ajax({
                                url: 'ajax_notification',
                                method: 'GET',
                                data: {
                                    read_notification: alert.id
                                },
                                success: res => {
                                    if (res.code === 200) {
                                        location.href = this.href;
                                    }
                                }
                            });
                        });
                        notifyContainer.prepend(notification);
                    });
                } else {
                    notifyContainer.html(
                        `<h6 class="text-muted text-center py-5">कोणतेही नोटीफिकेशन नाहीत</h6>`);
                }
            },
            error: xhr => {
                // console.log(xhr)
            },
            complete: () => {
                //
            }
        })

    });
    Date.prototype.getToday = function (separator = '/') {
        let y = this.getFullYear();
        let m = this.getMonth() + 1;
        let d = this.getDate();
        m = m < 10 ? '0' + m : m;
        d = d < 10 ? '0' + d : d;
        return y + separator + m + separator + d;
    }
    // Date.prototype.getFormatedDate = function(format='yyyy-mm-dd') {
    // 	const def = {
    // 		yy: this.getFullYear() % 100,
    // 		yyyy: this.getFullYear(),
    // 		mmm: this.toDateString().split(' ')[1],
    // 		mm: ('0' + (this.getMonth() + 1)).substr(-2),
    // 		ddd: this.toDateString().split(' ')[0],
    // 		dd: ('0' + this.getDate()).substr(-2)
    // 	}
    // 	let rt = format;
    // 	format.split(/[^a-zA-Z]/).forEach(el=>{
    // 		el = el.toLowerCase();
    // 		if (def[el]) {
    // 			rt = rt.replace(el, def[el]);
    // 		}
    // 	});
    // 	return rt.replaceAll('$', '');
    // }
    // Date.prototype.getFormatedTime = function(format='hh:MM:SS') {
    // 	let am_pm = false;
    // 	let _am_pm = this.getHours() >=12 ? 'pm' : 'am';
    // 	const def = {
    // 		HH: ('0' + this.getHours()).substr(-2),
    // 		hh: ('0' + ((this.getHours()>12) ? (this.getHours() -12) : this.getHours())).substr(-2),
    // 		MM: ('0' + this.getMinutes()).substr(-2),
    // 		SS: ('0' + this.getSeconds()).substr(-2),
    // 		a: _am_pm,
    // 		A: _am_pm.toUpperCase(),
    // 	}
    // 	let rt = format;
    // 	format = format.replace('a', ' a').replace('A', ' A').split(/[^a-zA-Z]/);
    // 	if (format.includes('A') || format.includes('a')) {
    // 		am_pm = true;
    // 	}
    // 	format.forEach(el=>{
    // 		if (def[el]) {
    // 			if (am_pm && el=='HH') {
    // 				rt = rt.replace(el, def.hh);
    // 			} else {
    // 				rt = rt.replace(el, def[el]);
    // 			}
    // 		}
    // 	});
    // 	return rt.replaceAll('$', '');
    // }
    // Date.prototype.getFormated = function(format='yyyy-mm-dd hh:MM:SS') {
    // 	let am_pm = false;
    // 	let _am_pm = this.getHours() >=12 ? 'pm' : 'am';
    // 	const def = {
    // 		yy: this.getFullYear() % 100,
    // 		yyyy: this.getFullYear(),
    // 		mmm: this.toDateString().split(' ')[1],
    // 		mm: ('0' + (this.getMonth() + 1)).substr(-2),
    // 		ddd: this.toDateString().split(' ')[0],
    // 		dd: ('0' + this.getDate()).substr(-2),
    // 		HH: ('0' + this.getHours()).substr(-2),
    // 		hh: ('0' + ((this.getHours()>12) ? (this.getHours() -12) : this.getHours())).substr(-2),
    // 		MM: ('0' + this.getMinutes()).substr(-2),
    // 		SS: ('0' + this.getSeconds()).substr(-2),
    // 		a: _am_pm,
    // 		A: _am_pm.toUpperCase(),
    // 	}
    // 	let rt = format;
    // 	format = format.replace('a', ' a').replace('A', ' A').split(/[^a-zA-Z]/);
    // 	if (format.includes('A')) {
    // 		am_pm = true;
    // 		rt = rt.replace('A', def.A);
    // 	} else if (format.includes('a')) {
    // 		am_pm = true;
    // 		rt = rt.replace('a', def.a);
    // 	}
    // 	format = format.filter(el => (el!='a' && el!='A'));;
    // 	format.forEach(el=>{
    // 		if (def[el]) {
    // 			if (am_pm && el=='HH') {
    // 				rt = rt.replace(el, def.hh);
    // 			} else {
    // 				rt = rt.replace(el, def[el]);
    // 			}
    // 		}
    // 	});
    // 	return rt.replaceAll('$', '');
    // }
    $.fn.dataTableExt.buttons.csvHtml5.charset = 'UTF-8', $.fn.dataTableExt.buttons.csvHtml5.bom = true, $.fn.dataTableExt
        .buttons.pdfHtml5.customize = function (doc) {
            doc.defaultStyle.font = 'NotoSans';
        };

    $.fn.dataTable.Api.register('sum()', function () {
        return this.flatten().reduce(function (a, b) {
            if (typeof a === 'string') {
                a = a.replace(/[^\d.-]/g, '') * 1;
            }
            if (typeof b === 'string') {
                b = b.replace(/[^\d.-]/g, '') * 1;
            }

            return a + b;
        }, 0);
    });

    $.fn.dataTableExt.buttons.csvHtml5.charset = 'UTF-8',
        $.fn.dataTableExt.buttons.csvHtml5.bom = true;
    $.fn.dataTableExt.buttons.copyHtml5.footer = true,
        $.fn.dataTableExt.buttons.excelHtml5.footer = true,
        $.fn.dataTableExt.buttons.csvHtml5.footer = true,
        $.fn.dataTableExt.buttons.pdfHtml5.footer = true,
        $.fn.dataTableExt.buttons.print.footer = true;
    const pdf = $.fn.dataTableExt.buttons.pdfHtml5;
    pdf.orientation = 'landscape',
        pdf.exportOptions = {
            columns: ':visible',
            search: 'applied',
            order: 'applied'
        },
        pdf.customize = function (doc) {
            doc.defaultStyle.font = 'NotoSans';
            doc.pageMargins = [20, 40, 20, 40];
            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
            const body = doc.content[1].table.body;
            for (let i = 0; i < Object.values(body).length; i++) {
                for (let j = 0; j < Object.values(body[i]).length; j++) {
                    // body[i][j].color = '#000'; // change font color
                    // body[i][j].fillColor = '#fff'; // change background color of cell
                    body[i][j].alignment = 'left'; // text alignment
                }
            }
        };

    $.fn.dataTable.Api.register('sum()', function () {
        return this.flatten().reduce(function (a, b) {
            if (typeof a === 'string') {
                a = a.replace(/[^\d.-]/g, '') * 1;
            }
            if (typeof b === 'string') {
                b = b.replace(/[^\d.-]/g, '') * 1;
            }

            return a + b;
        }, 0);
    });
    $.fn.dataTable.moment = function (format, locale) {
        var types = $.fn.dataTable.ext.type;
        // Add type detection
        types.detect.unshift(function (d) {
            return moment(d, format, locale, true).isValid() ?
                'moment-' + format :
                null;
        });
        // Add sorting method - use an integer for the sorting
        types.order['moment-' + format + '-pre'] = function (d) {
            return moment(d, format, locale, true).unix();
        };
    };
    $.fn.dataTable.moment('DD MMM YYYY');
    let example2table, protbltable, suptbl, purtbl, custbl, salesh, inward_expense, bank, cash, bink, usna;

    function clearDataTableFilters(table, form) {
        try {
            $(form).trigger('reset');
            return table.columns().search('').draw();
        } catch { }
    }
    Object.defineProperty(String.prototype, 'toTitleCase', {
        value: function () {
            return this.charAt(0).toUpperCase() + this.slice(1);
        },
        enumerable: false
    });
    $(document).ready(function () {
        $('.flatpickr').flatpickr();
        $('#example').DataTable();

        example2table = $('#example2').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, 500, -1],
                [10, 25, 50, 100, 500, 'All'],
            ],
            buttons: [{
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm btn-outline-dark me-2',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    // 		{
                    // 		    extend: 'pdf',
                    // 		    customize: function(doc) {
                    // 		    	// console.log(doc)
                    // 		        // const tbl = $(win.document.body).find('table')
                    // 		        // if (tbl.hasClass('multicheck-container')) {
                    // 		        // 	tbl.find('th:first-child, td:first-child').remove();
                    // 		        // }
                    // 		    }
                    // 		},
                    {
                        extend: 'print',
                        customize: function (win) {
                            const tbl = $(win.document.body).find('table')
                            if (tbl.hasClass('multicheck-container')) {
                                tbl.find('th:first-child, td:first-child').remove();
                            }
                        }
                    }
                ]
            },]
        });
        example2table.buttons().container().prependTo('.export-container');

        protbltable = $('#protbl').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, 500, -1],
                [10, 25, 50, 100, 500, 'All'],
            ],
            buttons: [{
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm btn-outline-dark me-2',
                buttons: [
                    'copy',
                    'excel',
                    // 		'csv',
                    // 		'pdf',
                    'print'
                ]
            }]
        }).buttons().container().prependTo('.export-container-pro');

        suptbl = $('#suppliertbl').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, 500, -1],
                [10, 25, 50, 100, 500, 'All'],
            ],
            buttons: [{
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm btn-outline-dark me-2',
                buttons: [
                    'copy',
                    'excel',
                    // 		'csv',
                    // 		'pdf',
                    'print'
                ]
            }]
        }).buttons().container().prependTo('.export-container-sup');

        purtbl = $('#purchasetbl').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, 500, -1],
                [10, 25, 50, 100, 500, 'All'],
            ],
            buttons: [{
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm btn-outline-dark me-2',
                buttons: [
                    'copy',
                    'excel',
                    // 		'csv',
                    // 		'pdf',
                    'print'
                ]
            }]
        }).buttons().container().prependTo('.export-container-pur');

        custbl = $('#customertbl').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, 500, -1],
                [10, 25, 50, 100, 500, 'All'],
            ],
            buttons: [{
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm btn-outline-dark me-2',
                buttons: [
                    'copy',
                    'excel',
                    // 		'csv',
                    // 		'pdf',
                    'print'
                ]
            }]
        }).buttons().container().prependTo('.export-container-cus');

        salesh = $('#salestbl').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, 500, -1],
                [10, 25, 50, 100, 500, 'All'],
            ],
            buttons: [{
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm btn-outline-dark me-2',
                buttons: [
                    'copy',
                    'excel',
                    // 		'csv',
                    // 		'pdf',
                    'print'
                ]
            }]
        }).buttons().container().prependTo('.export-container-salesh');

        quot = $('#quottbl').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, 500, -1],
                [10, 25, 50, 100, 500, 'All'],
            ],
            buttons: [{
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm btn-outline-dark me-2',
                buttons: [
                    'copy',
                    'excel',
                    // 		'csv',
                    // 		'pdf',
                    'print'
                ]
            }]
        }).buttons().container().prependTo('.export-container-quot');

        //onday_inward
        inward_expense = $('#inwardExpensetbl').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, 500, -1],
                [10, 25, 50, 100, 500, 'All'],
            ],
            buttons: [{
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm btn-outline-dark me-2',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    // 		'pdf',
                    'print'
                ]
            }]
        }).buttons().container().prependTo('.export-container-inwardEx');

        bank = $('#banktbl').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, 500, -1],
                [10, 25, 50, 100, 500, 'All'],
            ],
            buttons: [{
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm btn-outline-dark me-2',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    // 		'pdf',
                    'print'
                ]
            }]
        }).buttons().container().prependTo('.export-container-bank');

        cash = $('#cashtbl').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, 500, -1],
                [10, 25, 50, 100, 500, 'All'],
            ],
            buttons: [{
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm btn-outline-dark me-2',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    // 		'pdf',
                    'print'
                ]
            }]
        }).buttons().container().prependTo('.export-container-cash');
        bink = $('#binktbl').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, 500, -1],
                [10, 25, 50, 100, 500, 'All'],
            ],
            buttons: [{
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm btn-outline-dark me-2',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    // 		'pdf',
                    'print'
                ]
            }]
        }).buttons().container().prependTo('.export-container-bink');
        usna = $('#usnatbl').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, 500, -1],
                [10, 25, 50, 100, 500, 'All'],
            ],
            buttons: [{
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm btn-outline-dark me-2',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    // 		'pdf',
                    'print'
                ]
            }]
        }).buttons().container().prependTo('.export-container-usna');
    });

    function allowType(e, o = 'number', l = false, c = false) {
        let val = e.target.value;
        const devn = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
        switch (o) {
            case 'alfanum':
                if (l) {
                    val = val.substr(0, l).replaceAll(/[^0-9a-zA-Z]/gmi, '');
                } else {
                    val = val.replaceAll(/[^0-9a-zA-Z]/gmi, '');
                }
                break;
            case 'number':
                devn.forEach(dn => {
                    val = val.replaceAll(dn, devn.indexOf(dn));
                });
                if (l) {
                    val = val.substr(0, l).replaceAll(/[^0-9]/gmi, '');
                } else {
                    val = val.replaceAll(/[^0-9]/gmi, '');
                }
                break;
            case 'mobile':
                devn.forEach(dn => {
                    val = val.replaceAll(dn, devn.indexOf(dn));
                });
                val = val.replaceAll(/[^0-9]/gmi, '');
                val = val.substr(0, 10);
                if (!val.charAt(0).match(/[6-9]/)) {
                    val = val.substr(1);
                }
                break;
            case 'decimal':
                devn.forEach(dn => {
                    val = val.replaceAll(dn, devn.indexOf(dn));
                });
                let i = val.search(/\./gmi);
                if (val.length === 1) {
                    val = val.replaceAll(/[^0-9]/gmi, '');
                }
                if (i >= 0) {
                    if (l) {
                        val = val.substr(0, i + 1) + val.substr(i).substr(0, l + 1).replaceAll(/\./gmi, '');
                    } else {
                        val = val.substr(0, i + 1) + val.substr(i).replaceAll(/\./gmi, '');
                    }
                }
                val = val.replaceAll(/[^0-9.]/gmi, '');
                break;
        }
        if (c == 'upper') {
            val = val.toUpperCase();
        } else if (c == 'lower') {
            val = val.toLowerCase();
        } else if (c == 'title') {
            val = val.toTitleCase();
        }
        e.target.value = val;
    }
</script>
<script src="assets/js/app.js"></script>
<script src="assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="assets/plugins/chartjs/js/Chart.min.js"></script>
<script src="assets/plugins/chartjs/js/Chart.extension.js"></script>
<script src="assets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
<!-- Notification JS -->
<script src="assets/plugins/notifications/js/lobibox.min.js"></script>
<script src="assets/plugins/notifications/js/notifications.min.js"></script>
<script src="assets/js/index.js"></script>
<!--<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.13.1/af-2.5.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/date-1.2.0/fc-4.2.1/fh-3.3.1/kt-2.8.0/r-2.4.0/rg-1.3.0/rr-1.3.1/sc-2.0.7/sb-1.4.0/sp-2.1.0/sl-1.5.0/sr-1.2.0/datatables.min.js"></script>-->
<!--<script src="assets/js/vfs_fonts.js"></script>-->
<!--<script src="assets/js/photo.js"></script>-->
<?php if (isset($_GET['action'])): ?>
    <script>
        window.addEventListener('load', () => {
            alertModal.init('<?= ucwords($_GET['action ']) ?>', '<?= isset($_GET['action_msg ']) ? ucwords($_GET['action_msg ']) : ucwords($_GET['action ']) . 'Message ' ?>');
        });
    </script>
<!-- <script>
    function Bhajipala_sales(id) {
        window.location.href = 'bhajipala_sales?sale_id=' + id;
    }
</script> -->

<?php endif; ?>
<script src="assets/js/BSSelect.min.js"></script>
<script>
    // 		new BSSelect('#cat_id');
    // new BSSelect('#customer_id');
    // new BSSelect('#cus_id');
    // 		new BSSelect('#nid',{size:'sm'});
    // 		new BSSelect('#out');
    // 		new BSSelect('#in_id');
</script>
</body>

</html>