'use strict';
Object.defineProperty(String.prototype, 'toTitleCase', {
	value: function() {
		return this.charAt(0).toUpperCase() + this.slice(1);
	},
	enumerable: false
});
function changeLanguage(lang) {
	const form = $('#language-change-form');
	$('[name="language"]', form).val(lang);
	form.trigger('submit');
}
function translate(text) {
	const word = language_disctionary[text];
	if (word) {
		return word;
	}
	return text;
}
function setValueText(el, text) {
	$(el).val(text);
}
function to12Hrs(time24hrs) {
	time24hrs = time24hrs.split(':');
	let h = Number(time24hrs[0]);
	let i = Number(time24hrs[1]);
	let am_pm = (h > 11) ? 'PM' : 'AM';
	h %= 12;
	h = (h === 0) ? 12 : ('0'+h).slice(-2);
	i = ('0'+i).slice(-2);
	return `${h}:${i} ${am_pm}`;
}
Date.prototype.getTimeStr = function(f12hrs=false){
	let h = this.getHours();
	let i = this.getMinutes();
	let am_pm = (h > 11) ? 'PM' : 'AM';
	h = (h === 0) ? (f12hrs ? 12 : '00') : ('0'+h).slice(-2);
	i = ('0'+i).slice(-2);
	if (f12hrs) {
		return `${h}:${i}:00 ${am_pm}`;
	} else {
		return `${h}:${i}:00`;
	}
}
Date.prototype.getToday = function(separator='/'){
	let y = this.getFullYear();
	let m = this.getMonth() + 1;
	let d = this.getDate();
	m = m < 10 ? '0'+m : m;
	d = d < 10 ? '0'+d : d;
	return y+separator+m+separator+d;
}
Date.prototype.getFormatedDate = function(format='yyyy-mm-dd') {
	const def = {
		yy: this.getFullYear() % 100,
		yyyy: this.getFullYear(),
		mmm: this.toDateString().split(' ')[1],
		mm: ('0' + (this.getMonth() + 1)).substr(-2),
		ddd: this.toDateString().split(' ')[0],
		dd: ('0' + this.getDate()).substr(-2)
	}
	let rt = format;
	format.split(/[^a-zA-Z]/).forEach(el=>{
		el = el.toLowerCase();
		if (def[el]) {
			rt = rt.replace(el, def[el]);
		}
	});
	return rt.replaceAll('$', '');
}
Date.prototype.getFormatedTime = function(format='hh:MM:SS') {
	let am_pm = false;
	let _am_pm = this.getHours() >=12 ? 'pm' : 'am';
	const def = {
		HH: ('0' + this.getHours()).substr(-2),
		hh: ('0' + ((this.getHours()>12) ? (this.getHours() -12) : this.getHours())).substr(-2),
		MM: ('0' + this.getMinutes()).substr(-2),
		SS: ('0' + this.getSeconds()).substr(-2),
		a: _am_pm,
		A: _am_pm.toUpperCase(),
	}
	let rt = format;
	format = format.replace('a', ' a').replace('A', ' A').split(/[^a-zA-Z]/);
	if (format.includes('A') || format.includes('a')) {
		am_pm = true;
	}
	format.forEach(el=>{
		if (def[el]) {
			if (am_pm && el=='HH') {
				rt = rt.replace(el, def.hh);
			} else {
				rt = rt.replace(el, def[el]);
			}
		}
	});
	return rt.replaceAll('$', '');
}
Date.prototype.getFormated = function(format='yyyy-mm-dd hh:MM:SS') {
	let am_pm = false;
	let _am_pm = this.getHours() >=12 ? 'pm' : 'am';
	const def = {
		yy: this.getFullYear() % 100,
		yyyy: this.getFullYear(),
		mmm: this.toDateString().split(' ')[1],
		mm: ('0' + (this.getMonth() + 1)).substr(-2),
		ddd: this.toDateString().split(' ')[0],
		dd: ('0' + this.getDate()).substr(-2),
		HH: ('0' + this.getHours()).substr(-2),
		hh: ('0' + ((this.getHours()>12) ? (this.getHours() -12) : this.getHours())).substr(-2),
		MM: ('0' + this.getMinutes()).substr(-2),
		SS: ('0' + this.getSeconds()).substr(-2),
		a: _am_pm,
		A: _am_pm.toUpperCase(),
	}
	let rt = format;
	format = format.replace('a', ' a').replace('A', ' A').split(/[^a-zA-Z]/);
	if (format.includes('A')) {
		am_pm = true;
		rt = rt.replace('A', def.A);
	} else if (format.includes('a')) {
		am_pm = true;
		rt = rt.replace('a', def.a);
	}
	format = format.filter(el => (el!='a' && el!='A'));;
	format.forEach(el=>{
		if (def[el]) {
			if (am_pm && el=='HH') {
				rt = rt.replace(el, def.hh);
			} else {
				rt = rt.replace(el, def[el]);
			}
		}
	});
	return rt.replaceAll('$', '');
}
/**
 * @var	e	:	event
 * @var	o	:	option
 * @var	l	:	length
 * @var c	:	Case (upper|lower) 
 **/
function allowType(e, o = 'number', l = false, c=false) {
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
	if (c=='upper') {
		val = val.toUpperCase();
	} else if (c=='lower') {
		val = val.toLowerCase();
	} else if (c=='title') {
		val = val.toTitleCase();
	}
	e.target.value = val;
}

async function addUnitOption(el, text) {
	const unit = await Prompt({text});
	if (unit && unit.trim()) {
		$(el).append(`<option value="${unit}">${unit}</option>`).val(unit).trigger('change');
	}
}
function addProduct() {
	resetProductForm();
	$('#productAddModal').modal('show');
}

function resetProductForm() {
	$('#productAddModalLabel').text(translate('add_new_product'));
	$('#product-form-action').attr('name', 'add_product');
	$('#product-form [name="pro_stock"]').closest('.col-12').show();
	$('#productAddModal .modal-footer .delete-btn').remove();
	$('#product-form').trigger('reset');
}

function getProducts(pro_id = false) {
	const data = { get_products: true };
	if (pro_id) {
		data.pro_id = pro_id;
	}
	let returnRes = {};
	$.ajax({
		url: 'includes/api/products',
		method: 'POST',
		data: data,
		async: false,
		success: res => {
			if (res.status===200) {returnRes = res.data}
		},
		error: () => {
			//
		}
	});
	return returnRes;
}

function editProduct(pro_id) {
	resetProductForm();
	const product = getProducts(pro_id);
	if (product) {
		const parent = $('#productAddModal');
		$('#productAddModalLabel').text(translate('update_product'));
		$('#product-form-action').attr('name', 'update_product').val(product.pro_id);
		$('[name="pro_name"]', parent).val(product.pro_name);
		$('[name="pro_unit"]', parent).val(product.pro_unit);
		$('[name="pro_hsn"]', parent).val(product.pro_hsn);
		$('[name="pro_gst"]', parent).val(product.pro_gst);
		if (product.pro_gst_included==1) {
			$('#gst_included').prop('checked', true);
		} else {
			$('#gst_excluded').prop('checked', true);
		}
		$('[name="pro_type"]', parent).val(product.pro_type);
		$('[name="pro_cat_id"]', parent).val(product.pro_cat_id);
		$('[name="pro_sc_id"]', parent).val(product.pro_sc_id);
		$('[name="pro_br_id"]', parent).val(product.pro_br_id);
		$('[name="pro_sup_id"]', parent).val(product.pro_sup_id);
		$('[name="pro_stock"]', parent).closest('.col-12').hide();
		$('[name="pro_cost_price"]', parent).val(product.pro_cost_price);
		$('[name="pro_selling_price"]', parent).val(product.pro_selling_price);
		$('[name="pro_lowstock"]', parent).val(product.pro_lowstock);
		$('[name="pro_maxstock"]', parent).val(product.pro_maxstock);
		parent.find('.modal-footer').prepend(`<button type="button" class="delete-btn btn btn-sm btn-danger me-auto" onclick="deleteProduct(${product.pro_id})">${translate('delete_product')}</button>`);
		parent.modal('show');
	}
}

async function deleteProduct(pro_id) {
	const conf = await Confirm({
		text: `${translate('delete_product')}..?`,
		confirmText: translate('delete'),
		cancelText: translate('cancel')
	});
	if (conf) {
		$.ajax({
			url: 'includes/api/products',
			method: 'POST',
			data: {delete_product: true, pro_id: pro_id},
			success: res => {
				if ('undefined' !== typeof productListTable) {
					productListTable.ajax.reload();
				}
				resetProductForm();
				$('#productAddModal').modal('hide');
			}
		});
	}
}

function getStockList(options = {}) {
	const data = { get_stock_list: true };
	Object.assign(data, options);
	let returnRes = {};
	$.ajax({
		url: 'includes/api/products',
		method: 'POST',
		data: data,
		async: false,
		success: res => {
			if (res.status===200) {returnRes = res.data}
		},
		error: () => {
			//
		}
	});
	return returnRes;
}

$('#product-form').on('submit', function(e) {
	e.preventDefault();
	const form = $(this);
	const btn = $('#productAddModal button[type="submit"]');
	btn.startLoading();
	$.ajax({
		url: 'includes/api/products',
		method: 'POST',
		data: form.serialize(),
		success: res => {
			if ('undefined' !== typeof productListTable) {
				productListTable.ajax.reload();
			}
			renderProducts(res.data.pro_id);
			resetProductForm();
			$('#productAddModal').modal('hide');
		},
		error: () => {
			//
		},
		complete: function() {
			btn.stopLoading();
		}
	});
});

function renderProducts(pro_id = false) {
	$.ajax({
		url: 'includes/api/products',
		method: 'POST',
		data: { get_sowing_products: true },
		success: res => {
			$('[name="sw_pro_id"]').find('option:not([value=""])').remove();
			res.data.forEach(el => {
				$('[name="sw_pro_id"]').append(`<option value="${el.pro_id}">${el.pro_name_alt}</option>`);
				if (pro_id && pro_id == el.pro_id) {
					$('[name="sw_pro_id"]').val(el.pro_id).trigger('change');
				}
			});
		}
	});
}

function addCategory() {
	$('#category-form').trigger('reset');
	$('#categoryAddModal').modal('show');
}

$('#category-form').on('submit', function(e) {
	e.preventDefault();
	const form = $(this);
	const btn = $('#categoryAddModal button[type="submit"]');
	btn.startLoading();
	$.ajax({
		url: 'includes/api/products',
		method: 'POST',
		data: form.serialize(),
		success: res => {
			form.trigger('reset');
			$('#categoryAddModal').modal('hide');
			renderCategories(res.data.cat_id);
		},
		complete: () => {
			btn.stopLoading();
		}
	});
});

function renderCategories(cat_id = false) {
	$.ajax({
		url: 'includes/api/products',
		method: 'POST',
		data: { get_categories: true },
		success: res => {
			$('[name="pro_cat_id"]').find('option:not([value=""])').remove();
			$('[name="sc_cat_id"]').find('option:not([value=""])').remove();
			res.data.forEach(el => {
				$('[name="pro_cat_id"]').append(`<option value="${el.cat_id}">${el.cat_name}</option>`);
				if (cat_id && cat_id == el.cat_id) {
					$('[name="pro_cat_id"]').val(el.cat_id).trigger('change');
				}
				$('[name="sc_cat_id"]').append(`<option value="${el.cat_id}">${el.cat_name}</option>`);
			});
		}
	});
}

function addSubCategory() {
	$('#sub-category-form').trigger('reset');
	$('[name="sc_cat_id"]').val($('[name="pro_cat_id"]').val());
	$('#subCategoryAddModal').modal('show');
}
$('[name="pro_cat_id"]').on('change', function() {
	renderSubCategories(this.value);
});
$('#sub-category-form').on('submit', function(e) {
	e.preventDefault();
	const form = $(this);
	const btn = $('#subCategoryAddModal button[type="submit"]');
	btn.startLoading();
	$.ajax({
		url: 'includes/api/products',
		method: 'POST',
		data: form.serialize(),
		success: res => {
			form.trigger('reset');
			const cat_id = $('[name="pro_cat_id"]').val();
			$('#subCategoryAddModal').modal('hide');
			renderSubCategories(cat_id, res.data.sc_id);
		},
		complete: () => {
			btn.stopLoading();
		}
	});
});

function renderSubCategories(cat_id, sc_id = false) {
	$.ajax({
		url: 'includes/api/products',
		method: 'POST',
		data: { get_sub_categories: true, cat_id },
		success: res => {
			$('[name="pro_sc_id"]').find('option:not([value=""])').remove();
			res.data.forEach(el => {
				$('[name="pro_sc_id"]').append(`<option value="${el.sc_id}">${el.sc_name}</option>`);
				if (sc_id && sc_id == el.sc_id) {
					$('[name="pro_sc_id"]').val(el.sc_id).trigger('change');
				}
			});
		}
	});
}

function addBrand() {
	$('#brand-form').trigger('reset');
	$('#brandAddModal').modal('show');
}
$('#brand-form').on('submit', function(e) {
	e.preventDefault();
	const form = $(this);
	const btn = $('#brandAddModal button[type="submit"]');
	btn.startLoading();
	$.ajax({
		url: 'includes/api/products',
		method: 'POST',
		data: form.serialize(),
		success: res => {
			form.trigger('reset');
			$('#brandAddModal').modal('hide');
			renderBrands(res.data.br_id);
		},
		complete: () => {
			btn.stopLoading();
		}
	});
});

function renderBrands(br_id = false) {
	$.ajax({
		url: 'includes/api/products',
		method: 'POST',
		data: { get_brands: true },
		success: res => {
			$('[name="pro_br_id"]').find('option:not([value=""])').remove();
			res.data.forEach(el => {
				$('[name="pro_br_id"]').append(`<option value="${el.br_id}">${el.br_name}</option>`);
				if (br_id && br_id == el.br_id) {
					$('[name="pro_br_id"]').val(el.br_id).trigger('change');
				}
			});
		}
	});
}

function addSupplier() {
	resetSupplierForm();
	$('#supplierAddModal').modal('show');
}
function resetSupplierForm() {
	$('#supplierAddModalLabel').text(translate('add_new_supplier'));
	$('#supplier-form-action').attr('name', 'add_supplier');
	$('#supplierAddModal .modal-footer .delete-btn').remove();
	$('#supplier-form').trigger('reset');
}
function editSupplier(sup_id) {
	resetSupplierForm();
	$.ajax({
		url: 'includes/api/suppliers',
		method: 'POST',
		data: {get_suppliers: true, sup_id},
		success: res => {
			const supplier = res.data;
			if (Object.keys(supplier).length) {
				const parent = $('#supplierAddModal');
				$('#supplierAddModalLabel').text(translate('update_supplier'));
				$('#supplier-form-action').attr('name', 'update_supplier').val(supplier.sup_id);

				$('[name="sup_store_name"]', parent).val(supplier.sup_store_name);
				$('[name="sup_name"]', parent).val(supplier.sup_name);
				$('[name="sup_mobile"]', parent).val(supplier.sup_mobile);
				$('[name="sup_email"]', parent).val(supplier.sup_email);
				$('[name="sup_gst"]', parent).val(supplier.sup_gst);
				$('[name="sup_address"]', parent).val(supplier.sup_address);
				$('[name="sup_desc"]', parent).val(supplier.sup_desc);
				parent.find('.modal-footer').prepend(`<button type="button" class="delete-btn btn btn-sm btn-danger me-auto" onclick="deleteSupplier(${supplier.sup_id})">${translate('delete_supplier')}</button>`);
				parent.modal('show');
			}
		}
	});
}
$('#supplier-form').on('submit', function(e) {
	e.preventDefault();
	const form = $(this);
	const btn = $('#supplierAddModal button[type="submit"]');
	btn.startLoading();
	$.ajax({
		url: 'includes/api/suppliers',
		method: 'POST',
		data: form.serialize(),
		success: res => {
			$('#supplier-form').trigger('reset');
			$('#supplierAddModal').modal('hide');
			if ('undefined'!== typeof supplierListTable) {
				supplierListTable.ajax.reload();
			}
			resetSupplierForm();
			renderSupplier(res.data.sup_id);
		},
		complete: () => {
			btn.stopLoading();
		}
	});
});
async function deleteSupplier(sup_id) {
	const conf = await Confirm({
		text: `${translate('delete_supplier')}..?`,
		confirmText: translate('delete'),
		cancelText: translate('cancel')
	});
	if (conf) {
		$.ajax({
			url: 'includes/api/suppliers',
			method: 'POST',
			data: {delete_supplier: true, sup_id},
			success: res => {
				if ('undefined' !== typeof supplierListTable) {
					supplierListTable.ajax.reload();
				}
				resetSupplierForm();
				$('#supplierAddModal').modal('hide');
				setTimeout(() => {
					Alert({type: 'success', text: translate('supplier_deleted')});
				}, 200);
			}
		});
	}
}
function renderSupplier(sup_id = false) {
	$.ajax({
		url: 'includes/api/suppliers',
		method: 'POST',
		data: { get_suppliers: true },
		success: res => {
			$('[name="pro_sup_id"]').find('option:not([value=""])').remove();
			$('[name="po_sup_id"]').find('option:not([value=""])').remove();
			res.data.forEach(el => {
				$('[name="pro_sup_id"]').append(`<option value="${el.sup_id}">${el.sup_store_name}</option>`);
				$('[name="po_sup_id"]').append(`<option value="${el.sup_id}">${el.sup_store_name}</option>`);
				if (sup_id && sup_id == el.sup_id) {
					$('[name="pro_sup_id"]').val(el.sup_id).trigger('change');
					$('[name="po_sup_id"]').val(el.sup_id).trigger('change');
				}
			});
		}
	});
}

function addCustomer() {
	resetCustomerForm();
	$('#customerAddModal').modal('show');
}

function resetCustomerForm() {
	$('#customerAddModalLabel').text(translate('add_new_customer'));
	$('#customer-form-action').attr('name', 'add_customer');
	$('#customerAddModal .modal-footer .delete-btn').remove();
	$('#customer-form').trigger('reset');
}

function editCustomer(cus_id) {
	resetCustomerForm();
	$.ajax({
		url: 'includes/api/customers',
		method: 'POST',
		data: {get_customers: true, cus_id},
		success: res => {
			const customer = res.data;
			if (Object.keys(customer).length) {
				const parent = $('#customerAddModal');
				$('#customerAddModalLabel').text(translate('update_customer'));
				$('#customer-form-action').attr('name', 'update_customer').val(customer.cus_id);
				$('[name="cus_name"]', parent).val(customer.cus_name);
				$('[name="cus_mobile"]', parent).val(customer.cus_mobile);
				$('[name="cus_email"]', parent).val(customer.cus_email);
				$('[name="cus_gender"]', parent).val(customer.cus_gender);
				$('[name="cus_address"]', parent).val(customer.cus_address);
				parent.find('.modal-footer').prepend(`<button type="button" class="delete-btn btn btn-sm btn-danger me-auto" onclick="deleteCustomer(${customer.cus_id})">${translate('delete_customer')}</button>`);
				parent.modal('show');
			}
		}
	});
}

async function deleteCustomer(cus_id) {
	const conf = await Confirm({
		text: `${translate('delete_customer')}..?`,
		confirmText: translate('delete'),
		cancelText: translate('cancel')
	});
	if (conf) {
		$.ajax({
			url: 'includes/api/customers',
			method: 'POST',
			data: {delete_customer: true, cus_id},
			success: res => {
				if ('undefined' !== typeof customerListTable) {
					customerListTable.ajax.reload();
				}
				resetProductForm();
				$('#customerAddModal').modal('hide');
				setTimeout(() => {
					Alert({type: 'success', text: translate('customer_deleted')});
				}, 200);
			}
		});
	}
}

$('#customer-form').on('submit', function(e){
	e.preventDefault();
	const form = $(this);
	const modal = $('#customerAddModal');
	const btn = $('button[type="submit"]', modal);
	btn.startLoading();
	$.ajax({
		url: 'includes/api/customers',
		method: 'POST',
		data: form.serialize(),
		success: res => {
			if ('undefined'!== typeof customerListTable) {
				customerListTable.ajax.reload();
			}
			renderCustomer(res.data.cus_id);
			modal.modal('hide');
		},
		complete: () => {
			btn.stopLoading();
		}
	});
});

function renderCustomer(cus_id = false) {
	$.ajax({
		url: 'includes/api/customers',
		method: 'POST',
		data: { get_customers: true },
		success: res => {
			$('[name="bok_cus_id"]').find('option:not([value=""])').remove();
			$('[name="bill_cus_id"]').find('option:not([value=""])').remove();
			res.data.forEach(el => {
				$('[name="bill_cus_id"]').append(`<option value="${el.cus_id}">${el.cus_name}</option>`);
				$('[name="bok_cus_id"]').append(`<option value="${el.cus_id}">${el.cus_name}</option>`);
				if (cus_id && cus_id == el.cus_id) {
					$('[name="bok_cus_id"]').val(el.cus_id).trigger('change');
					$('[name="bill_cus_id"]').val(el.cus_id).trigger('change');
				}
			});
		}
	});
}

function addUser() {
	resetUserForm();
	$('#userAddModal').modal('show');
}
function resetUserForm() {
	$('#userAddModalLabel').text(translate('add_new_user'));
	$('#user-form-action').attr('name', 'add_user');
	$('#userAddModal .modal-footer .delete-btn').remove();
	$('#user-form').trigger('reset');
}
function editUser(u_id) {
	resetUserForm();
	$.ajax({
		url: 'includes/api/users',
		method: 'POST',
		data: {get_users: true, u_id},
		success: res => {
			const user = res.data;
			if (Object.keys(user).length) {
				const parent = $('#userAddModal');
				$('#userAddModalLabel').text(translate('update_user'));
				$('#user-form-action').attr('name', 'update_user').val(user.u_id);

				$('[name="u_fname"]', parent).val(user.u_fname);
				$('[name="u_lname"]', parent).val(user.u_lname);
				$('[name="u_mobile"]', parent).val(user.u_mobile);
				$('[name="u_email"]', parent).val(user.u_email);
				$('[name="u_role"]', parent).val(user.u_role);
				if (user.u_type!=='primary') {
					parent.find('.modal-footer').prepend(`<button type="button" class="delete-btn btn btn-sm btn-danger me-auto" onclick="deleteUser(${user.u_id})">${translate('delete_user')}</button>`);
				}
				parent.modal('show');
			}
		}
	});
}
async function deleteUser(u_id) {
	const conf = await Confirm({
		text: `${translate('delete_user')}..?`,
		confirmText: translate('delete'),
		cancelText: translate('cancel')
	});
	if (conf) {
		$.ajax({
			url: 'includes/api/users',
			method: 'POST',
			data: {delete_user: true, u_id},
			success: res => {
				if ('undefined' !== typeof usersListTable) {
					usersListTable.ajax.reload();
				}
				resetUserForm();
				$('#userAddModal').modal('hide');
				setTimeout(()=>{
					Alert({type: 'success', text: translate('user_deleted')});
				}, 200);
			},
			error: res => {
				Alert({type: 'warning', text: translate('unable_to_delete_user')});
			}
		});
	}
}
$('#user-form').on('submit', function(e){
	e.preventDefault();
	const form = $(this);
	const modal = $('#userAddModal');
	const btn = $('button[type="submit"]', modal);
	btn.startLoading();
	$('#user-form-error').text('').slideUp();
	$.ajax({
		url: 'includes/api/users',
		method: 'POST',
		data: form.serialize(),
		success: res => {
			$('#user-form-error').text('').slideUp();
			if ('undefined'!== typeof usersListTable) {
				usersListTable.ajax.reload();
			}
			modal.modal('hide');
		},
		error: (res) => {
			$('#user-form-error').text(res.responseJSON.msg).slideDown();
		},
		complete: () => {
			btn.stopLoading();
		}
	});
});
function addEmployee() {
	resetEmployeeForm();
	$('#employeeAddModal').modal('show');
}
function resetEmployeeForm() {
	$('#employeeAddModalLabel').text(translate('add_new_employee'));
	$('#employee-form-action').attr('name', 'add_employee');
	$('#employeeAddModal .modal-footer .delete-btn').remove();
	$('#employee-form').trigger('reset');
}
function editEmployee(emp_id) {
	resetEmployeeForm();
	$.ajax({
		url: 'includes/api/employees',
		method: 'POST',
		data: {get_employees: true, emp_id},
		success: res => {
			const employee = res.data;
			if (Object.keys(employee).length) {
				const parent = $('#employeeAddModal');
				$('#employeeAddModalLabel').text(translate('update_employee'));
				$('#employee-form-action').attr('name', 'update_employee').val(employee.emp_id);

				$('[name="emp_name"]', parent).val(employee.emp_name);
				$('[name="emp_mobile"]', parent).val(employee.emp_mobile);
				$('[name="emp_email"]', parent).val(employee.emp_email);
				$('[name="emp_salary"]', parent).val(employee.emp_salary);
				$('[name="emp_joined"]', parent).val(employee.emp_joined);
				$('[name="emp_gender"]', parent).val(employee.emp_gender);
				$('[name="emp_address"]', parent).val(employee.emp_address);
				
				parent.find('.modal-footer').prepend(`<button type="button" class="delete-btn btn btn-sm btn-danger me-auto" onclick="deleteEmployee(${employee.emp_id})">${translate('delete_employee')}</button>`);
				parent.modal('show');
			}
		}
	});
}
$('#employee-form').on('submit', function(e){
	e.preventDefault();
	const form = $(this);
	const modal = $('#employeeAddModal');
	const btn = $('button[type="submit"]', modal);
	btn.startLoading();
	$.ajax({
		url: 'includes/api/employees',
		method: 'POST',
		data: form.serialize(),
		success: res => {
			if ('undefined'!== typeof employeeListTable) {
				employeeListTable.ajax.reload();
			}
			modal.modal('hide');
		},
		complete: () => {
			btn.stopLoading();
		}
	});
});
async function deleteEmployee(emp_id) {
	const conf = await Confirm({
		text: `${translate('delete_employee')}..?`,
		confirmText: translate('delete'),
		cancelText: translate('cancel')
	});
	if (conf) {
		$.ajax({
			url: 'includes/api/employees',
			method: 'POST',
			data: {delete_employee: true, emp_id},
			success: res => {
				if ('undefined' !== typeof employeeListTable) {
					employeeListTable.ajax.reload();
				}
				resetEmployeeForm();
				$('#employeeAddModal').modal('hide');
				setTimeout(()=>{
					Alert({type: 'success', text: translate('employee_deleted')});
				}, 200);
			}
		});
	}
}
function addExpense() {
	resetExpenseForm();
	$('#expenseAddModal').modal('show');
}
function resetExpenseForm() {
	$('#expenseAddModalLabel').text(translate('add_new_expense'));
	$('#expense-form-action').attr('name', 'add_expense');
	$('#expenseAddModal .modal-footer .delete-btn').remove();
	$('#expense-form').trigger('reset');
}
function editExpense(exp_id) {
	resetExpenseForm();
	$.ajax({
		url: 'includes/api/expenses',
		method: 'POST',
		data: {get_expenses: true, exp_id},
		success: res => {
			const expense = res.data;
			if (Object.keys(expense).length) {
				const parent = $('#expenseAddModal');
				$('#expenseAddModalLabel').text(translate('update_expense'));
				$('#expense-form-action').attr('name', 'update_expense').val(expense.exp_id);
				$('[name="exp_to"]', parent).val(expense.exp_to),
				$('[name="exp_date"]', parent).val(expense.exp_date),
				$('[name="exp_date"]', parent).val(new Date(expense.exp_date).getFormated('yyyy-mm-dd')),
				$('[name="exp_amount"]', parent).val(expense.exp_amount),
				$('[name="exp_for"]', parent).val(expense.exp_for),
				$('[name="exp_paymode"]', parent).val(expense.exp_paymode),
				$('[name="exp_desc"]', parent).val(expense.exp_desc),
				parent.find('.modal-footer').prepend(`<button type="button" class="delete-btn btn btn-sm btn-danger me-auto" onclick="deleteExpense(${expense.exp_id})">${translate('delete_expense')}</button>`);
				$('#expenseAddModal').modal('show');
			}
		}
	});
}

$('#expense-form').on('submit', function(e){
	e.preventDefault();
	const form = $(this);
	const modal = $('#expenseAddModal');
	const btn = $('button[type="submit"]', modal);
	btn.startLoading();
	$.ajax({
		url: 'includes/api/expenses',
		method: 'POST',
		data: form.serialize(),
		success: res => {
			if ('undefined'!== typeof expensesListTable) {
				expensesListTable.ajax.reload();
			}
			modal.modal('hide');
		},
		complete: () => {
			btn.stopLoading();
		}
	});
});

async function deleteExpense(exp_id) {
	const conf = await Confirm({
		text: `${translate('delete_expense')}..?`,
		confirmText: translate('delete'),
		cancelText: translate('cancel')
	});
	if (conf) {
		$.ajax({
			url: 'includes/api/expenses',
			method: 'POST',
			data: {delete_expense: true, exp_id},
			success: res => {
				if ('undefined' !== typeof expensesListTable) {
					expensesListTable.ajax.reload();
				}
				resetExpenseForm();
				$('#expenseAddModal').modal('hide');
				setTimeout(() => {
					Alert({type: 'success', text: translate('expense_deleted')});
				}, 200);
			}
		});
	}
}

function addBooking() {
	$('#booking-form').trigger('reset');
	$('#bookingAddModal').modal('show');
}
function viewBooking(bok_id) {
	const modal = $('#invoicePreviewModal');
	modal.find('iframe').attr('src', `booking?bok_id=${bok_id}`);
	modal.find('.invoice-print-btn').attr('onclick', `printBooking(${bok_id})`);
	modal.modal('show');
}
function printBooking(bok_id) {
	const booking = window.open(`booking?bok_id=${bok_id}`, '_blank');
	booking.addEventListener('load', function(){
	    booking.print();
	    setTimeout(()=>{
	    	booking.close();
	    }, 100);
	});
}
function cloneBookingProduct() {
	const bookingProduct = $('.booking-product:first-child');
	const cloned = bookingProduct.clone();
	cloned.find('input').val('');
	cloned.find('td:last-child').html(`<a href="javascript:;" class="link-danger" onclick="deleteBookingProduct(this)"><i class="bi-x-circle-fill"></i></a>`)
	bookingProduct.closest('tbody').append(cloned);
	countBookingProduct();
}
function deleteBookingProduct(el) {
	$(el).closest('.booking-product').remove();
	calcBookingTotal();
	countBookingProduct();
}
function countBookingProduct() {
	const products = $('.booking-product');
	for (let i = 0; i < products.length; i++) {
		$('td:first-child', products[i]).text(i+1);
	}
}
function findProductStockPrice(el){
	const parent = $(el).closest('.booking-product');
	const optn = $('option:selected', el);
	const product = getProducts(optn.val());
	if (!Array.isArray(product) && 'object' === typeof product) {
		$('[name="bkd_pro_qty[]"]', parent).val(product.pro_stock);
		$('[name="bkd_pro_rate[]"]', parent).val(product.pro_selling_price);
		$('input[readonly]', parent).val((product.pro_stock * product.pro_selling_price).toFixed(2));
		calcBookingTotal();
	}
}
function calcBookingTotal() {
	const advance = $('[name="bok_advance_amount"]', '#bookingAddModal').val();
	const products = $('.booking-product');
	let total_qty = 0, total_amount = 0, remaining = 0;
	for (let i = 0; i < products.length; i++) {
		const qty = $('[name="bkd_pro_qty[]"]', products[i]).val();
		const price = $('[name="bkd_pro_rate[]"]', products[i]).val();
		const subtotal = Number(qty) * Number(price);
		$('input[readonly]', products[i]).val(subtotal.toFixed(2));
		total_qty += Number(qty);
		total_amount += Number(subtotal.toFixed(2));
	}
	$('#bok_qty').val(total_qty);
	$('#bok_total_amount').val(total_amount.toFixed(2));
	$('#bok_balance_amount').val((total_amount - Number(advance)).toFixed(2));
}
$('#booking-form').on('submit', function(e){
	e.preventDefault();
	if (!$('[name="bok_delivery_date"]').val()) {
		return Alert({type: 'warning', text: translate('select_delivery_date')});
	}
	const form = $(this);
	const modal = $('#bookingAddModal');
	const btn = $('button[type="submit"]', modal);
	btn.startLoading();
	$.ajax({
		url: 'includes/api/bookings',
		method: 'POST',
		data: form.serialize(),
		success: res => {
			const bok_id = res.data.bok_id;
			if (bok_id) {
				if ('undefined'!== typeof bookingListTable) {
					bookingListTable.ajax.reload();
				}
				modal.modal('hide');
				viewBooking(bok_id);
			}
		},
		complete: () => {
			btn.stopLoading();
		}
	});
});
// Purchase
function addPurchase() {
	$('#purchase-form').trigger('reset');
	$('#purchaseAddModal').modal('show');
}
function viewPurchase(po_id) {
	const modal = $('#invoicePreviewModal');
	modal.find('iframe').attr('src', `po?po_id=${po_id}`);
	modal.find('.invoice-print-btn').attr('onclick', `printPurchase(${po_id})`);
	modal.modal('show');
}
function printPurchase(po_id) {
	const purchase = window.open(`po?po_id=${po_id}`, '_blank');
	purchase.addEventListener('load', function(){
	    purchase.print();
	    setTimeout(()=>{
	    	purchase.close();
	    }, 1);
	});
}
function clonePurchaseProduct() {
	const purchaseProduct = $('.purchase-product:first-child');
	const cloned = purchaseProduct.clone();
	cloned.find('input').val('');
	cloned.find('td:last-child').html(`<a href="javascript:;" class="link-danger" onclick="deletePurchaseProduct(this)"><i class="bi-x-circle-fill"></i></a>`)
	purchaseProduct.closest('tbody').append(cloned);
	countPurchaseProduct();
}
function deletePurchaseProduct(el) {
	$(el).closest('.purchase-product').remove();
	calcPurchaseTotal();
	countPurchaseProduct();
}
function countPurchaseProduct() {
	const products = $('.purchase-product');
	for (let i = 0; i < products.length; i++) {
		$('td:first-child', products[i]).text(i+1);
	}
}
function findPurchaseProductStockPrice(el){
	const parent = $(el).closest('.purchase-product');
	const optn = $('option:selected', el);
	const product = getProducts(optn.val());
	if (!Array.isArray(product) && 'object' === typeof product) {
		$('[name="pod_pro_price[]"]', parent).val(product.pro_cost_price);
		calcPurchaseTotal();
	}
}
function addFees(el) {
	$(el).closest('.po-fees-section').find('.po-fees-list').append(`<div class="col-12 po-fees-item">
		<div class="row g-3">
			<div class="col-6">
				<label class="form-label">${translate('fees_name')}</label>
				<input type="text" name="po_fees_name[]" class="form-control form-control-sm" required>
			</div>
			<div class="col-6">
				<label class="form-label">${translate('amount')} <span class="rupee"></span></label>
				<div class="input-group input-group-sm">
					<span class="input-group-text px-2">
						<i class="bi bi-currency-rupee"></i>
					</span>
					<input type="text" name="po_fees[]" class="form-control rounded-1 px-2" oninput="allowType(event, 'decimal', 2),calcPurchaseTotal();" value="0.00" required onfocus="this.select()">
					<button class="btn border-0 p-0" type="button" onclick="removeFees(this)">
						<i class="bi bi-x-circle-fill p-1 ms-1 text-danger"></i>
					</button>
				</div>
			</div>
		</div>
	</div>`);
}
function removeFees(el) {
	$(el).closest('.po-fees-item').remove();
	calcPurchaseTotal();
}
function calcPurchaseTotal() {
	const products = $('.purchase-product');
	let total_qty = 0, total_amount = 0, total_discount = 0, total_tax = 0, fees = 0;
	const feesInput = $('[name="po_fees[]"]');
	for (let i = 0; i < products.length; i++) {
		const pro = $('[name="pod_pro_id[]"] option:selected', products[i]);
		const qty = $('[name="pod_pro_qty[]"]', products[i]).val();
		const price = $('[name="pod_pro_price[]"]', products[i]).val();
		const subtotal = Number(qty) * Number(price);
		const discount_rate = $('[name="pod_pro_discount[]"]', products[i]).val();
		const discount_isflat = Boolean(Number($('[name="pod_pro_discount_isflat[]"]', products[i]).val()));
		let discount,taxes;
		if (discount_isflat) {
			discount = Number(discount_rate);
		} else {
			discount = (subtotal * Number(discount_rate) / 100);
		}
		const total = Number((subtotal - discount).toFixed(2));
		const gst_rate = Number(pro.attr('pro-gst'));
		const gst_included = Number(pro.attr('pro-gst-included'));
		if (gst_included) {
			taxes = Number((total * gst_rate / (100 + gst_rate)).toFixed(2));
			total_amount += Number((subtotal - taxes).toFixed(2));
			$('.po-pro-subtotal', products[i]).val((subtotal - taxes).toFixed(2));
		} else {
			taxes = Number((total * gst_rate / 100).toFixed(2));
			total_amount += Number(subtotal.toFixed(2));
			$('.po-pro-subtotal', products[i]).val(subtotal.toFixed(2));
		}
		total_qty += Number(qty);
		total_discount += Number(discount.toFixed(2));
		total_tax += Number(taxes.toFixed(2));
	}
	for (let j = 0; j < feesInput.length; j++) {
		fees += Number(feesInput[j].value);
	}
	const grand_total = (total_amount - total_discount + total_tax + fees);
	$('#po_qty').val(total_qty);
	$('#po_subtotal').val(total_amount.toFixed(2));
	$('#po_discount_amount').val(total_discount.toFixed(2));
	$('#po_tax_amount').val(total_tax.toFixed(2));
	$('#po_fees_total').val(fees.toFixed(2));
	$('#po_total').val(grand_total.toFixed(2));
}
$('#purchase-form').on('submit', function(e){
	e.preventDefault();
	if (!$('[name="po_expected_by"]').val()) {
		$('[name="po_expected_by"]').focus()[0].scrollIntoView();
		return Alert({type: 'warning', text: translate('select_expected_date')});
	}
	const form = $(this);
	const modal = $('#purchaseAddModal');
	const btn = $('button[type="submit"]', modal);
	btn.startLoading();
	$.ajax({
		url: 'includes/api/purchase',
		method: 'POST',
		data: form.serialize(),
		success: res => {
			if ('undefined'!== typeof purchaseListTable) {
				purchaseListTable.ajax.reload();
			}
			modal.modal('hide');
		},
		complete: () => {
			btn.stopLoading();
		}
	});
});
async function receivePurchaseOrder(po_id) {
	const save = await Confirm({
		text: translate('confirm_add_po_to_stock'),
		cancelText: translate('cancel'),
		confirmText: translate('add'),
	});
	if (save) {
		$.ajax({
			url: 'includes/api/purchase',
			method: 'POST',
			data: {receive_purchase: po_id},
			success: res => {
				if ('undefined'!== typeof purchaseListTable) {
					purchaseListTable.ajax.reload();
				}
			},
			complete: () => {
			}
		});
	}
}
// Billing
function addBill() {
	$('#billing-form').trigger('reset');
	$('#billingAddModal').modal('show');
}
function viewBill(bill_id) {
	const modal = $('#invoicePreviewModal');
	modal.find('iframe').attr('src', `invoice?bill_id=${bill_id}`);
	modal.find('.invoice-print-btn').attr('onclick', `printBill(${bill_id})`);
	modal.modal('show');
}
function printBill(bill_id) {
	const invoice = window.open(`invoice?bill_id=${bill_id}`, '_blank');
	invoice.addEventListener('load', function(){
	    invoice.print();
	    setTimeout(()=>{
	    	invoice.close();
	    }, 100);
	});
}
function cloneBillProduct() {
	const billingProduct = $('.billing-product:first-child');
	const cloned = billingProduct.clone();
	cloned.find('input').val('');
	cloned.find('td:last-child').html(`<a href="javascript:;" class="link-danger" onclick="deleteBillProduct(this)"><i class="bi-x-circle-fill"></i></a>`)
	billingProduct.closest('tbody').append(cloned);
	countBillProduct();
}
function deleteBillProduct(el) {
	$(el).closest('.billing-product').remove();
	calcBillTotal();
	countBillProduct();
}
function countBillProduct() {
	const products = $('.billing-product');
	for (let i = 0; i < products.length; i++) {
		$('td:first-child', products[i]).text(i+1);
	}
}

function addBillFees(el) {
	$(el).closest('.bill-fees-section').find('.bill-fees-list').append(`<div class="col-12 bill-fees-item">
		<div class="row g-3">
			<div class="col-6">
				<label class="form-label">${translate('fees_name')}</label>
				<input type="text" name="bill_fees_name[]" class="form-control form-control-sm" required>
			</div>
			<div class="col-6">
				<label class="form-label">${translate('amount')} <span class="rupee"></span></label>
				<div class="input-group input-group-sm">
					<span class="input-group-text px-2">
						<i class="bi bi-currency-rupee"></i>
					</span>
					<input type="text" name="bill_fees[]" class="form-control rounded-1 px-2" oninput="allowType(event, 'decimal', 2),calcBillTotal();" value="0.00" required onfocus="this.select()">
					<button class="btn border-0 p-0" type="button" onclick="removeBillFees(this)">
						<i class="bi bi-x-circle-fill p-1 ms-1 text-danger"></i>
					</button>
				</div>
			</div>
		</div>
	</div>`);
}

function removeBillFees(el) {
	$(el).closest('.bill-fees-item').remove();
	calcBillTotal();
}

function addBillAdvance(el) {
	const advance = $(`<div class="col-12 bill-advance-item">
		<div class="row g-3">
			<div class="col-6">
				<label class="form-label">${translate('received_date')}</label>
				<div class="input-group input-group-sm">
					<span class="input-group-text px-2">
						<i class="bi-calendar-week"></i>
					</span>
					<input type="text" name="bill_advance_date[]" class="js-flatpickr form-control form-control-sm" required value="${new Date().getToday('-')}">
				</div>
			</div>
			<div class="col-6">
				<label class="form-label">${translate('amount')} <span class="rupee"></span></label>
				<div class="input-group input-group-sm">
					<span class="input-group-text px-2">
						<i class="bi bi-currency-rupee"></i>
					</span>
					<input type="text" name="bill_advance_amount[]" class="form-control rounded-end-1 px-2" oninput="allowType(event, 'decimal', 2),calcBillTotal();" value="0.00" required onfocus="this.select()">
					<button class="btn border-0 p-0" type="button" onclick="removeBillAdvance(this)">
						<i class="bi bi-x-circle-fill p-1 ms-1 text-danger"></i>
					</button>
				</div>
			</div>
		</div>
	</div>`);
	$(el).closest('.bill-advance-section').find('.bill-advance-list').append(advance);
	HSCore.components.HSFlatpickr.init($('.js-flatpickr:last-child', advance)[0], {dateFormat: 'Y-m-d'});
}

function removeBillAdvance(el) {
	$(el).closest('.bill-advance-item').remove();
	calcBillTotal();
}

function findBillProductStockPrice(el){
	const parent = $(el).closest('.billing-product');
	const optn = $('option:selected', el);
	const st_id = optn.attr('pro-stock-id');
	$('[name="bds_st_id[]"]', parent).val(st_id);
	const product = getStockList({st_id});
	if (!Array.isArray(product) && 'object' === typeof product) {
		$('[name="bds_pro_qty[]"]', parent).val(product.st_remain);
		$('[name="bds_pro_qty[]"]', parent).attr('max', product.st_remain);
		$('[name="bds_pro_rate[]"]', parent).val(product.st_selling_price);
	} else {
		$('[name="bds_pro_qty[]"]', parent).val('');
		$('[name="bds_pro_qty[]"]', parent).attr('max', '');
		$('[name="bds_pro_rate[]"]', parent).val('');
	}
	calcBillTotal();
}

function calcBillTotal() {
	const products = $('.billing-product');
	let total_qty = 0, total_amount = 0, total_discount = 0, total_tax = 0, fees = 0, advance = 0;
	const feesInput = $('[name="bill_fees[]"]');
	const advanceInput = $('[name="bill_advance_amount[]"]');
	const selected = {};

	for (let i = 0; i < products.length; i++) {
		const pro = $('[name="bds_pro_id[]"] option:selected', products[i]);
		const st_id = pro.attr('pro-stock-id');
		const avail_qty = Number($('[name="bds_pro_qty[]"]', products[i]).attr('max'));
		if (st_id && undefined === selected[st_id]) {
			selected[st_id] = 0;
		}
		let qty = $('[name="bds_pro_qty[]"]', products[i]).val();
		selected[st_id] += Number(qty);
		if (avail_qty && (selected[st_id] > avail_qty)) {
			Alert(translate('max_n_quantity').replaceAll('%d', Number(avail_qty)));
			$('[name="bds_pro_qty[]"]', products[i]).val('');
			qty = 0;
		}
		const price = $('[name="bds_pro_rate[]"]', products[i]).val();
		const subtotal = Number(qty) * Number(price);
		const discount_rate = $('[name="bds_discount[]"]', products[i]).val();
		const discount_isflat = Boolean(Number($('[name="bds_discount_isflat[]"]', products[i]).val()));
		let discount,taxes;
		if (discount_isflat) {
			discount = Number(discount_rate);
		} else {
			discount = (subtotal * Number(discount_rate) / 100);
		}
		const total = Number((subtotal - discount).toFixed(2));
		const gst_rate = Number(pro.attr('pro-gst'));
		const gst_included = Number(pro.attr('pro-gst-included'));
		if (gst_included) {
			taxes = Number((total * gst_rate / (100 + gst_rate)).toFixed(2));
			total_amount += Number((subtotal - taxes).toFixed(2));
			$('.bill-pro-subtotal', products[i]).val((subtotal - taxes).toFixed(2));
		} else {
			taxes = Number((total * gst_rate / 100).toFixed(2));
			total_amount += Number((subtotal).toFixed(2));
			$('.bill-pro-subtotal', products[i]).val(subtotal.toFixed(2));
		}
		$('.bill-pro-taxes', products[i]).val(taxes.toFixed(2));
		total_qty += Number(qty);
		total_discount += Number(discount.toFixed(2));
		total_tax += Number(taxes.toFixed(2));
	}
	for (let j = 0; j < feesInput.length; j++) {
		fees += Number(feesInput[j].value);
	}
	for (let k = 0; k < advanceInput.length; k++) {
		advance += Number(advanceInput[k].value);
	}
	const grand_total = (total_amount - total_discount + total_tax + fees);
	$('#bill_qty').val(total_qty);
	$('#bill_total_amount').val(total_amount.toFixed(2));
	$('#bill_discount_amount').val(total_discount.toFixed(2));
	$('#bill_tax_amount').val(total_tax.toFixed(2));
	$('#bill_fees_amount').val(fees.toFixed(2));
	$('#bill_grand_total').val(grand_total.toFixed(2));
	$('[name="bill_paid"]').val(advance.toFixed(2));
	$('#bill_balance').val((grand_total - advance).toFixed(2));
}

$('#billing-form').on('submit', async function(e){
	e.preventDefault();
	let isValid = true;
	const save_type = $('#billing-form-type').val();
	document.querySelectorAll('[name="bill_advance_date[]"]').forEach(el => {
		if (!el.value) {
			isValid = false;
			el.focus();
			el.scrollIntoView();
			return Alert({type: 'warning', text: translate('select_advance_or_payment_received_date')});
		}
	});
	const form = $(this);
	const modal = $('#billingAddModal');
	let btn = $(`button[type="submit"][name="${save_type}"]`, modal);
	if (isValid) {
		let save;
		if (save_type=='invoice') {
			save = await Confirm({
				text: translate('confirm_save_bill'),
				cancelText: translate('cancel'),
				confirmText: translate('save'),
			});
		} else if (save_type=='quotation') {
			save = await Confirm({
				text: translate('confirm_save_quotation'),
				cancelText: translate('cancel'),
				confirmText: translate('save'),
			});
		}
		if (save) {
			btn.startLoading();
			$.ajax({
				url: 'includes/api/billing',
				method: 'POST',
				data: form.serialize(),
				success: res => {
					const bill_id = res.data.bill_id;
					if (bill_id) {
						if ('undefined'!== typeof billingListTable) {
							billingListTable.ajax.reload();
						}
						modal.modal('hide');
						viewBill(bill_id);
					}
				},
				complete: () => {
					btn.stopLoading();
				}
			});
		}
	}
});

function receiveBillAmount(bill_id) {
	$('#receiveBillAmount').modal('show');
}
function addSowing() {
	$('#sowing-form').trigger('reset');
	const modal = $('#sowingAddModal')
	$('[name="sw_date"]', modal).val(new Date().getFormated('yyyy-mm-dd'));
	modal.modal('show');
}
function cloneSowingProduct(){
	const sowingProduct = $('.sowing-product:first-child');
	const cloned = sowingProduct.clone();
	cloned.find('input').val('');
	cloned.find('td:last-child').html(`<a href="javascript:;" class="link-danger" onclick="deleteSowingProduct(this)"><i class="bi-x-circle-fill"></i></a>`)
	sowingProduct.closest('tbody').append(cloned);
	countSowingProduct();
}
function deleteSowingProduct(el) {
	$(el).closest('.sowing-product').remove();
	calcSowingTotal();
	countSowingProduct();
}
function countSowingProduct() {
	const products = $('.sowing-product');
	for (let i = 0; i < products.length; i++) {
		$('td:first-child', products[i]).text(i+1);
	}
}
function findSowingProductStockPrice(el) {
	const parent = $(el).closest('.sowing-product');
	const optn = $('option:selected', el);
	const product = getProducts(optn.val());
	if (!Array.isArray(product) && 'object' === typeof product) {
		$('[name="swd_pro_cost_price[]"]', parent).val(Number(product.pro_cost_price).toFixed(2));
		$('.swd-pro-avail-qty', parent).val(product.pro_stock);
		calcSowingTotal();
	}
}
function selectSowingProduct(pro_id) {
	const parent = $('#sowingAddModal');
	const product = getProducts(pro_id);
	// name="sw_pro_cost_price"
	// name="sw_pro_selling_price"
	// name="sw_pro_qty"
	// name="sw_production_cost"
	if (!Array.isArray(product) && 'object' === typeof product) {
		$('[name="sw_pro_cost_price"]', parent).val(Number(product.pro_cost_price).toFixed(2));
		$('[name="sw_pro_selling_price"]', parent).val(Number(product.pro_selling_price).toFixed(2));
		calcSowingTotal();
	}
}
function calcSowingTotal() {
	const products = $('.sowing-product');
	let total_amount = 0;
	const selected = {};
	for (let i = 0; i < products.length; i++) {
		const product = $('[name="swd_pro_id[]"] option:selected', products[i]);
		if (product.val() && undefined === selected[product.val()]) {
			selected[product.val()] = 0;
		}
		const price = $('[name="swd_pro_cost_price[]"]', products[i]).val();
		const avail_qty = $('.swd-pro-avail-qty', products[i]).val();
		let qty = $('[name="swd_pro_qty[]"]', products[i]).val();
		selected[product.val()] += Number(qty);
		if (avail_qty && (selected[product.val()] > Number(avail_qty))) {
			Alert(translate('max_n_quantity').replaceAll('%d', Number(avail_qty)));
			$('[name="swd_pro_qty[]"]', products[i]).val('');
			qty = 0;
		}
		const subtotal = Number(qty) * Number(price);
		total_amount += Number(subtotal);
		$('.swd-pro-total', products[i]).val(subtotal.toFixed(2));
	}
	const plants = Number($('[name="sw_pro_qty"]').val());
	const production_cost = plants ? (total_amount / plants) : 0;
	$('[name="sw_production_cost"]').val(production_cost.toFixed(2));
}
function countSowingSeeds() {
	const products = $('.sowing-product');
	let seeds = 0;
	for (let i = 0; i < products.length; i++) {
		const product = $('[name="swd_pro_id[]"] option:selected', products[i]);
		if (product.attr('pro-type')==='seed') {
			seeds++;
		}
	}
	return seeds;
}
$('#sowing-form').on('submit', async function(e){
	e.preventDefault();
	const seeds = countSowingSeeds();
	if (!$('[name="sw_date"]').val()) {
		return Alert({type: 'warning', text: translate('select_sowing_date')});
	} else if (!seeds) {
		return Alert({type: 'warning', text: translate('select_seed_for_sowing')});
	} else if (seeds > 1) {
		return Alert({type: 'warning', text: translate('select_only_one_seed_for_sowing')});
	} else {
		const form = $(this);
		const modal = $('#sowingAddModal');
		let btn = $(`button[type="submit"]`, modal);
		const save = await Confirm({
			text: translate('confirm_save_sowing'),
			cancelText: translate('no'),
			confirmText: translate('yes'),
		});
		if (save) {
			btn.startLoading();
			$.ajax({
				url: 'includes/api/sowings',
				method: 'POST',
				data: form.serialize(),
				success: res => {
					if ('undefined'!== typeof sowingListTable) {
						sowingListTable.ajax.reload();
					}
					modal.modal('hide');
				},
				complete: () => {
					btn.stopLoading();
				}
			});
		}
	}
});
function addEmployeeAdvance() {
	resetEmployeeAdvanceForm();
	$('#employeeAdvanceAddModal').modal('show');
}
function resetEmployeeAdvanceForm() {
	$('#employeeAdvanceAddModalLabel').text(translate('give_advance_borrowing'));
	$('#advance-form-action').attr('name', 'add_advance');
	$('#employeeAdvanceAddModal .modal-footer .delete-btn').remove();
	$('#advance-form').trigger('reset');
	$('#advance-form [name="ead_date"]').val(new Date().getToday('-'));
}
function editEmployeeAdvance(ead_id) {
	resetEmployeeAdvanceForm();
	$.ajax({
		url: 'includes/api/advance',
		method: 'POST',
		data: {get_advance: true, ead_id},
		success: res => {
			const advance = res.data;
			if (Object.keys(advance).length) {
				const parent = $('#employeeAdvanceAddModal');
				$('#employeeAdvanceAddModalLabel').text(translate('update_advance_borrowing'));
				$('#advance-form-action').attr('name', 'update_advance').val(advance.ead_id),
				$('[name="ead_date"]', parent).val(advance.ead_date),
				$('[name="ead_emp_id"]', parent).val(advance.ead_emp_id),
				$('[name="ead_amount"]', parent).val(advance.ead_amount),
				$('[name="ead_reason"]', parent).val(advance.ead_reason),
				parent.find('.modal-footer').prepend(`<button type="button" class="delete-btn btn btn-sm btn-danger me-auto" onclick="deleteEmployeeAdvance(${advance.ead_id})">${translate('delete_advance_borrowing')}</button>`);
				parent.modal('show');
			}
		}
	});
}
$('#advance-form').on('submit', function(e){
	e.preventDefault();
	const form = $(this);
	const modal = $('#employeeAdvanceAddModal');
	const btn = $('button[type="submit"]', modal);
	btn.startLoading();
	$.ajax({
		url: 'includes/api/advance',
		method: 'POST',
		data: form.serialize(),
		success: res => {
			if ('undefined'!== typeof advanceListTable) {
				advanceListTable.ajax.reload();
			}
			modal.modal('hide');
		},
		complete: () => {
			btn.stopLoading();
		}
	});
});

async function deleteEmployeeAdvance(ead_id) {
	const conf = await Confirm({
		text: `${translate('delete_advance_borrowing')}..?`,
		confirmText: translate('delete'),
		cancelText: translate('cancel')
	});
	if (conf) {
		$.ajax({
			url: 'includes/api/advance',
			method: 'POST',
			data: {delete_advance: true, ead_id},
			success: res => {
				if ('undefined' !== typeof advanceListTable) {
					advanceListTable.ajax.reload();
				}
				resetExpenseForm();
				$('#employeeAdvanceAddModal').modal('hide');
				setTimeout(() => {
					Alert({type: 'success', text: translate('advance_borrowing_deleted')});
				}, 200);
			}
		});
	}
}

/**
 * @admin
 **/
function getBusiness(biz_id) {
	let data = false;
	$.ajax({
		url: 'includes/api/business',
		method: 'POST',
		data: {get_businesses: true, biz_id},
		async: false,
		success: res => {
			data = res.data;
		}
	});
	return data;
}

function viewBusiness(biz_id) {
	const biz = getBusiness(biz_id);
	if (Object.keys(biz).length) {
		const parent = $('#businessPreviewModal');
		$('#businessPreviewModalLabel', parent).text(biz.biz_name);
		let subscriptions = '';
		let users = '';
		biz.subscriptions.forEach(s => {
			let type_cls, status_cls;
			if (s.sub_pac_type === 'trial') {
				type_cls = 'dark';
			} else if (s.sub_pac_type === 'paid') {
				type_cls = 'success';
			}
			if (s.sub_status === 'active') {
				status_cls = 'success';
			} else if (s.sub_status === 'expired') {
				status_cls = 'danger';
			}
			subscriptions += `<div class="p-2 p-md-3 mt-3 rounded-2 border shadow-sm">
				<div>
					<strong>${translate('subscription')} : </strong>
					<span class="badge text-${type_cls} border border-${type_cls} bg-${type_cls} bg-opacity-25 bg-gradient rounded-pill lh-1">${translate(s.sub_pac_type)}</span>
				</div>
				<div>
					<strong>${translate('subscription_started_date')} : </strong>
					${new Date(s.sub_started).getFormated('dd mmm yyyy')}
				</div>
				<div>
					<strong>${translate('subscription_expiry_date')} : </strong>
					${new Date(s.sub_ends).getFormated('dd mmm yyyy')}
				</div>
				<div>
					<strong>${translate('subscription_status')} : </strong>
					<span class="badge text-${status_cls} border border-${status_cls} bg-${status_cls} bg-opacity-25 bg-gradient rounded-pill lh-1">${translate(s.sub_status)}</span>
				</div>
				<div class="d-flex gap-3">
					<div>
						<strong>${translate('price')} : </strong>
						<span class="rupee">${Number(s.sub_price).toFixed(2)}</span>
					</div>
					<div>
						<strong>${translate('received_amount')} : </strong>
						<span class="rupee">${Number(s.sub_received).toFixed(2)}</span>
					</div>
					<div>
						<strong>${translate('paymode')} : </strong>
						<span class="badge text-info bg-info bg-opacity-25 bg-gradient rounded-pill lh-1 border border-info">${translate(s.sub_paymod)}</span>
					</div>
				</div>
			</div>`;
		});
		biz.users.forEach(u => {
			users += `<div class="p-2 p-md-3 mb-3 rounded-2 border shadow-sm">
				<div>
					<strong>${translate('name')} : </strong>
					<span>${u.u_full_name}</span>
				</div>
				<div>
					<strong>${translate('mobile')} : </strong>
					<span>${u.u_mobile}</span>
				</div>
				<div>
					<strong>${translate('email')} : </strong>
					<span>${u.u_email}</span>
				</div>
			</div>`;
		});
		$('.modal-body .row', parent).html(`<div class="col-12 col-md-3">
						<strong>${translate('business_name')}</strong>
					</div>
					<div class="col-12 col-md-9">${biz.biz_name}</div>
					<div class="col-12 col-md-3">
						<strong>${translate('business_email')}</strong>
					</div>
					<div class="col-12 col-md-9">${biz.biz_email}</div>
					<div class="col-12 col-md-3">
						<strong>${translate('business_contacts')}</strong>
					</div>
					<div class="col-12 col-md-9">${biz.biz_contact}</div>
					<div class="col-12 col-md-3">
						<strong>${translate('gst_no')}</strong>
					</div>
					<div class="col-12 col-md-9">${biz.biz_gst}</div>
					<div class="col-12 col-md-3">
						<strong>${translate('business_website')}</strong>
					</div>
					<div class="col-12 col-md-9">${biz.biz_website}</div>
					<div class="col-12 col-md-3">
						<strong>${translate('address')}</strong>
					</div>
					<div class="col-12 col-md-9">${Object.values(biz.biz_address).filter(v => v).join(',')}</div>
					<div class="col-12 col-md-3">
						<strong>${translate('users')}</strong>
					</div>
					<div class="col-12 col-md-9">
						${users}
					</div>
					<div class="col-12 col-md-3">
						<strong>${translate('subscription_info')}</strong>
					</div>
					<div class="col-12 col-md-9">
						<div class="text-end">
							<button class="btn btn-sm btn-outline-primary py-1" onclick="renewSubscription(${biz.biz_id}, true)">${translate('renew')}</button>
						</div>
						${subscriptions}
					</div>`);
		parent.modal('show');
	}
}
function renewSubscription(biz_id, preview_biz=false) {
	const biz = getBusiness(biz_id);
	const form = $('#subscription-renewal-form');
	form.trigger('reset');
	form.attr('preview_biz', preview_biz);
	if (Object.keys(biz).length) {
		const parent = $('#subscriptionRenewalModal');
		$('.sub_biz_name', parent).text(biz.biz_name);
		$('[name="sub_biz_id"]', parent).val(biz.biz_id);
		if (!biz.biz_onetime_fees) {
			$('[name="sub_type"]', parent).val('new');
			$('.registration_charges').slideDown().find('input').prop('disabled', false);
			$('.renewal_charges').slideDown().find('input').prop('disabled', false);
			$('[name="sub_received"]', parent).prop('readonly', true);
		} else {
			$('[name="sub_type"]', parent).val('renew');
			$('.registration_charges').slideUp().find('input').prop('disabled', true);
			$('.renewal_charges').slideUp().find('input').prop('disabled', true);
			$('[name="sub_received"]', parent).prop('readonly', false);
		}
		parent.modal('show');
	}
}
function calcSubReceived() {
	const parent = $('#subscriptionRenewalModal');
	const sub_type = $('[name="sub_type"]', parent).val();
	const biz_renewal_charges = $('[name="biz_renewal_charges"]', parent);
	const sub_received = $('[name="sub_received"]', parent);
	if (sub_type=='new') {
		if (Number(biz_renewal_charges.val())) {
			sub_received.val(Number(biz_renewal_charges.val()).toFixed(2));
		}
	}
}
$('#subscription-renewal-form').on('submit', function(e){
	e.preventDefault();
	const form = $(this);
	const parent = $('#subscriptionRenewalModal');
	const btn = $('button[type="submit"]', parent);
	btn.startLoading();
	const preview_biz = form.attr('preview_biz');
	$.ajax({
		url: 'includes/api/business',
		method: 'POST',
		data: form.serialize(),
		success: res => {
			if ('undefined'!== typeof businessListTable) {
				businessListTable.ajax.reload();
			}
			parent.modal('hide');
			$('#businessPreviewModal').modal('hide');
			if (preview_biz=='true') {
				viewBusiness($('[name="sub_biz_id"]', parent).val());
			}
		},
		complete: () => {
			btn.stopLoading();
		}
	});
});