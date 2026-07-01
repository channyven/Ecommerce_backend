/**
 * Admin Panel — Theme & Locale Manager
 * Handles dark/light mode toggle and English/Khmer translation.
 */

// ──────────────────────────────────────
// Translations
// ──────────────────────────────────────
const translations = {
  en: {
    'admin.dashboard': 'Dashboard',
    'admin.categories': 'Categories',
    'admin.products': 'Products',
    'admin.orders': 'Orders',
    'admin.customers': 'Customers',
    'admin.logout': 'Logout',
    'admin.panel': 'Admin Panel',
    'admin.login.title': 'Admin Login',
    'admin.login.subtitle': 'Sign in to manage your store',
    'admin.login.email': 'Email',
    'admin.login.password': 'Password',
    'admin.login.remember': 'Remember me',
    'admin.login.button': 'Sign In',
    'admin.dashboard.title': 'Dashboard',
    'admin.dashboard.subtitle': 'Overview of your skincare store',
    'admin.dashboard.total_products': 'Total Products',
    'admin.dashboard.total_orders': 'Total Orders',
    'admin.dashboard.total_revenue': 'Total Revenue',
    'admin.dashboard.customers': 'Customers',
    'admin.dashboard.recent_orders': 'Recent Orders',
    'admin.dashboard.low_stock': 'Low Stock Products',
    'admin.dashboard.no_orders': 'No orders yet.',
    'admin.dashboard.all_stocked': 'All products are well-stocked.',
    'admin.products.title': 'Products',
    'admin.products.subtitle': 'Manage your product inventory',
    'admin.products.new': '+ New Product',
    'admin.products.name': 'Product',
    'admin.products.category': 'Category',
    'admin.products.price': 'Price',
    'admin.products.stock': 'Stock',
    'admin.products.status': 'Status',
    'admin.products.actions': 'Actions',
    'admin.products.edit': 'Edit',
    'admin.products.delete': 'Delete',
    'admin.products.none': 'No products found. Create your first product!',
    'admin.products.back': 'Back to Products',
    'admin.products.create': 'Create Product',
    'admin.products.edit_title': 'Edit',
    'admin.products.name_label': 'Name *',
    'admin.products.slug': 'Slug',
    'admin.products.short_desc': 'Short Description',
    'admin.products.full_desc': 'Full Description',
    'admin.products.price_label': 'Price * ($)',
    'admin.products.compare_price': 'Compare Price ($)',
    'admin.products.quantity': 'Quantity *',
    'admin.products.sku': 'SKU',
    'admin.products.images': 'Product Images',
    'admin.products.images_hint': 'JPEG, PNG, or WebP. Max 2MB each. First image becomes the thumbnail.',
    'admin.products.featured': 'Featured',
    'admin.products.active': 'Active',
    'admin.products.submit_create': 'Create Product',
    'admin.products.submit_update': 'Update Product',
    'admin.products.current_images': 'Current Images',
    'admin.products.add_images': 'Add New Images',
    'admin.products.primary': 'Primary',
    'admin.categories.title': 'Categories',
    'admin.categories.subtitle': 'Manage your product categories',
    'admin.categories.new': '+ New Category',
    'admin.categories.name': 'Name',
    'admin.categories.slug': 'Slug',
    'admin.categories.parent': 'Parent',
    'admin.categories.count': 'Products',
    'admin.categories.active': 'Active',
    'admin.categories.actions': 'Actions',
    'admin.categories.edit': 'Edit',
    'admin.categories.delete': 'Delete',
    'admin.categories.none': 'No categories found. Create your first category!',
    'admin.categories.back': 'Back to Categories',
    'admin.categories.create': 'Create Category',
    'admin.categories.edit_title': 'Edit',
    'admin.categories.name_label': 'Name *',
    'admin.categories.description': 'Description',
    'admin.categories.parent_label': 'Parent Category',
    'admin.categories.no_parent': '— No Parent (Top Level) —',
    'admin.categories.sort_order': 'Sort Order',
    'admin.categories.active_label': 'Active',
    'admin.categories.submit_create': 'Create Category',
    'admin.categories.submit_update': 'Update Category',
    'admin.orders.title': 'Orders',
    'admin.orders.subtitle': 'View and manage customer orders',
    'admin.orders.order': 'Order #',
    'admin.orders.customer': 'Customer',
    'admin.orders.total': 'Total',
    'admin.orders.status': 'Status',
    'admin.orders.payment': 'Payment',
    'admin.orders.date': 'Date',
    'admin.orders.actions': 'Actions',
    'admin.orders.view': 'View',
    'admin.orders.none': 'No orders yet.',
    'admin.orders.back': 'Back to Orders',
    'admin.orders.items': 'Order Items',
    'admin.orders.product': 'Product',
    'admin.orders.price': 'Price',
    'admin.orders.qty': 'Qty',
    'admin.orders.line_total': 'Total',
    'admin.orders.subtotal': 'Subtotal',
    'admin.orders.shipping': 'Shipping',
    'admin.orders.tax': 'Tax',
    'admin.orders.discount': 'Discount',
    'admin.orders.grand_total': 'Total',
    'admin.orders.summary': 'Order Summary',
    'admin.orders.payment_status': 'Payment',
    'admin.orders.method': 'Method',
    'admin.orders.coupon': 'Coupon',
    'admin.orders.date_label': 'Date',
    'admin.orders.customer_info': 'Customer',
    'admin.orders.shipping_address': 'Shipping Address',
    'admin.orders.notes': 'Order Notes',
    'admin.customers.title': 'Customers',
    'admin.customers.subtitle': 'View registered customers',
    'admin.customers.name': 'Name',
    'admin.customers.email': 'Email',
    'admin.customers.phone': 'Phone',
    'admin.customers.orders': 'Orders',
    'admin.customers.joined': 'Joined',
    'admin.customers.actions': 'Actions',
    'admin.customers.view': 'View',
    'admin.customers.none': 'No customers registered yet.',
    'admin.customers.back': 'Back to Customers',
    'admin.customers.info': 'Customer Info',
    'admin.customers.status': 'Status',
    'admin.customers.recent_orders': 'Recent Orders',
    'admin.customers.no_orders': "This customer hasn't placed any orders yet.",
    'admin.theme': 'Theme',
    'admin.language': 'Language',
    'admin.search': 'Search',
    'admin.no_sku': 'No SKU',
    'admin.yes': 'Yes',
    'admin.no': 'No',
    'admin.in_stock': 'In Stock',
    'admin.low_stock': 'Low Stock',
    'admin.out_of_stock': 'Out of Stock',
  },

  km: {
    'admin.dashboard': 'ផ្ទាំងគ្រប់គ្រង',
    'admin.categories': 'ប្រភេទ',
    'admin.products': 'ផលិតផល',
    'admin.orders': 'ការបញ្ជាទិញ',
    'admin.customers': 'អតិថិជន',
    'admin.logout': 'ចេញ',
    'admin.panel': 'ផ្ទាំងគ្រប់គ្រង',
    'admin.login.title': 'ចូលគ្រប់គ្រង',
    'admin.login.subtitle': 'ចូលដើម្បីគ្រប់គ្រងហាងរបស់អ្នក',
    'admin.login.email': 'អ៊ីមែល',
    'admin.login.password': 'ពាក្យសម្ងាត់',
    'admin.login.remember': 'ចងចាំខ្ញុំ',
    'admin.login.button': 'ចូល',
    'admin.dashboard.title': 'ផ្ទាំងគ្រប់គ្រង',
    'admin.dashboard.subtitle': 'ទិដ្ឋភាពទូទៅនៃហាងគ្រឿងសម្អាងរបស់អ្នក',
    'admin.dashboard.total_products': 'ផលិតផលសរុប',
    'admin.dashboard.total_orders': 'ការបញ្ជាទិញសរុប',
    'admin.dashboard.total_revenue': 'ចំណូលសរុប',
    'admin.dashboard.customers': 'អតិថិជន',
    'admin.dashboard.recent_orders': 'ការបញ្ជាទិញថ្មីៗ',
    'admin.dashboard.low_stock': 'ផលិតផលជិតអស់ស្តុក',
    'admin.dashboard.no_orders': 'មិនទាន់មានការបញ្ជាទិញនៅឡើយទេ។',
    'admin.dashboard.all_stocked': 'ផលិតផលទាំងអស់មានស្តុកគ្រប់គ្រាន់។',
    'admin.products.title': 'ផលិតផល',
    'admin.products.subtitle': 'គ្រប់គ្រងស្តុកផលិតផលរបស់អ្នក',
    'admin.products.new': '+ ផលិតផលថ្មី',
    'admin.products.name': 'ផលិតផល',
    'admin.products.category': 'ប្រភេទ',
    'admin.products.price': 'តម្លៃ',
    'admin.products.stock': 'ស្តុក',
    'admin.products.status': 'ស្ថានភាព',
    'admin.products.actions': 'សកម្មភាព',
    'admin.products.edit': 'កែប្រែ',
    'admin.products.delete': 'លុប',
    'admin.products.none': 'រកមិនឃើញផលិតផលទេ។ បង្កើតផលិតផលដំបូងរបស់អ្នក!',
    'admin.products.back': 'ត្រឡប់ទៅផលិតផល',
    'admin.products.create': 'បង្កើតផលិតផល',
    'admin.products.edit_title': 'កែប្រែ',
    'admin.products.name_label': 'ឈ្មោះ *',
    'admin.products.slug': 'Slug',
    'admin.products.short_desc': 'ការពិពណ៌នាខ្លី',
    'admin.products.full_desc': 'ការពិពណ៌នាពេញ',
    'admin.products.price_label': 'តម្លៃ * ($)',
    'admin.products.compare_price': 'តម្លៃប្រៀបធៀប ($)',
    'admin.products.quantity': 'បរិមាណ *',
    'admin.products.sku': 'SKU',
    'admin.products.images': 'រូបភាពផលិតផល',
    'admin.products.images_hint': 'JPEG, PNG, ឬ WebP។ អតិបរមា 2MB នីមួយៗ។ រូបភាពទីមួយក្លាយជារូបភាពតំណាង។',
    'admin.products.featured': 'ពិសេស',
    'admin.products.active': 'សកម្ម',
    'admin.products.submit_create': 'បង្កើតផលិតផល',
    'admin.products.submit_update': 'ធ្វើបច្ចុប្បន្នភាពផលិតផល',
    'admin.products.current_images': 'រូបភាពបច្ចុប្បន្ន',
    'admin.products.add_images': 'បន្ថែមរូបភាពថ្មី',
    'admin.products.primary': 'តំណាង',
    'admin.categories.title': 'ប្រភេទ',
    'admin.categories.subtitle': 'គ្រប់គ្រងប្រភេទផលិតផល',
    'admin.categories.new': '+ ប្រភេទថ្មី',
    'admin.categories.name': 'ឈ្មោះ',
    'admin.categories.slug': 'Slug',
    'admin.categories.parent': 'មេ',
    'admin.categories.count': 'ផលិតផល',
    'admin.categories.active': 'សកម្ម',
    'admin.categories.actions': 'សកម្មភាព',
    'admin.categories.edit': 'កែប្រែ',
    'admin.categories.delete': 'លុប',
    'admin.categories.none': 'រកមិនឃើញប្រភេទទេ។ បង្កើតប្រភេទដំបូងរបស់អ្នក!',
    'admin.categories.back': 'ត្រឡប់ទៅប្រភេទ',
    'admin.categories.create': 'បង្កើតប្រភេទ',
    'admin.categories.edit_title': 'កែប្រែ',
    'admin.categories.name_label': 'ឈ្មោះ *',
    'admin.categories.description': 'ការពិពណ៌នា',
    'admin.categories.parent_label': 'ប្រភេទមេ',
    'admin.categories.no_parent': '— គ្មានមេ (កម្រិតកំពូល) —',
    'admin.categories.sort_order': 'លំដាប់',
    'admin.categories.active_label': 'សកម្ម',
    'admin.categories.submit_create': 'បង្កើតប្រភេទ',
    'admin.categories.submit_update': 'ធ្វើបច្ចុប្បន្នភាពប្រភេទ',
    'admin.orders.title': 'ការបញ្ជាទិញ',
    'admin.orders.subtitle': 'មើល និងគ្រប់គ្រងការបញ្ជាទិញអតិថិជន',
    'admin.orders.order': 'លេខការបញ្ជាទិញ',
    'admin.orders.customer': 'អតិថិជន',
    'admin.orders.total': 'សរុប',
    'admin.orders.status': 'ស្ថានភាព',
    'admin.orders.payment': 'ការបង់ប្រាក់',
    'admin.orders.date': 'កាលបរិច្ឆេទ',
    'admin.orders.actions': 'សកម្មភាព',
    'admin.orders.view': 'មើល',
    'admin.orders.none': 'មិនទាន់មានការបញ្ជាទិញនៅឡើយទេ។',
    'admin.orders.back': 'ត្រឡប់ទៅការបញ្ជាទិញ',
    'admin.orders.items': 'ធាតុការបញ្ជាទិញ',
    'admin.orders.product': 'ផលិតផល',
    'admin.orders.price': 'តម្លៃ',
    'admin.orders.qty': 'បរិមាណ',
    'admin.orders.line_total': 'សរុប',
    'admin.orders.subtotal': 'សរុបរង',
    'admin.orders.shipping': 'ការដឹកជញ្ជូន',
    'admin.orders.tax': 'ពន្ធ',
    'admin.orders.discount': 'បញ្ចុះតម្លៃ',
    'admin.orders.grand_total': 'សរុប',
    'admin.orders.summary': 'សង្ខេបការបញ្ជាទិញ',
    'admin.orders.payment_status': 'ការបង់ប្រាក់',
    'admin.orders.method': 'វិធីសាស្ត្រ',
    'admin.orders.coupon': 'ប័ណ្ណបញ្ចុះតម្លៃ',
    'admin.orders.date_label': 'កាលបរិច្ឆេទ',
    'admin.orders.customer_info': 'អតិថិជន',
    'admin.orders.shipping_address': 'អាសយដ្ឋានដឹកជញ្ជូន',
    'admin.orders.notes': 'កំណត់ចំណាំការបញ្ជាទិញ',
    'admin.customers.title': 'អតិថិជន',
    'admin.customers.subtitle': 'មើលអតិថិជនដែលបានចុះឈ្មោះ',
    'admin.customers.name': 'ឈ្មោះ',
    'admin.customers.email': 'អ៊ីមែល',
    'admin.customers.phone': 'ទូរស័ព្ទ',
    'admin.customers.orders': 'ការបញ្ជាទិញ',
    'admin.customers.joined': 'ចុះឈ្មោះ',
    'admin.customers.actions': 'សកម្មភាព',
    'admin.customers.view': 'មើល',
    'admin.customers.none': 'មិនទាន់មានអតិថិជនចុះឈ្មោះនៅឡើយទេ។',
    'admin.customers.back': 'ត្រឡប់ទៅអតិថិជន',
    'admin.customers.info': 'ព័ត៌មានអតិថិជន',
    'admin.customers.status': 'ស្ថានភាព',
    'admin.customers.recent_orders': 'ការបញ្ជាទិញថ្មីៗ',
    'admin.customers.no_orders': 'អតិថិជននេះមិនទាន់ដាក់ការបញ្ជាទិញនៅឡើយទេ។',
    'admin.theme': 'ប្រធានបទ',
    'admin.language': 'ភាសា',
    'admin.search': 'ស្វែងរក',
    'admin.no_sku': 'គ្មាន SKU',
    'admin.yes': 'បាទ/ចាស',
    'admin.no': 'ទេ',
    'admin.in_stock': 'មានស្តុក',
    'admin.low_stock': 'ជិតអស់',
    'admin.out_of_stock': 'អស់ស្តុក',
  },
}

let currentLocale = 'en'
let localeData = translations.en

/**
 * Get translated text for a key.
 */
function __(key, fallback = key) {
  return localeData[key] || fallback
}

/**
 * Set the current locale and update all elements with data-i18n attributes.
 */
function setLocale(lang) {
  currentLocale = lang
  localeData = translations[lang] || translations.en
  localStorage.setItem('admin_locale', lang)
  document.documentElement.lang = lang === 'km' ? 'km' : 'en'
  applyTranslations()
  updateLocaleButton()
}

/**
 * Apply translations to all elements with data-i18n attributes.
 */
function applyTranslations() {
  document.querySelectorAll('[data-i18n]').forEach(el => {
    const key = el.getAttribute('data-i18n')
    el.textContent = __(key)
  })
  document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
    const key = el.getAttribute('data-i18n-placeholder')
    el.placeholder = __(key)
  })
  document.querySelectorAll('[data-i18n-value]').forEach(el => {
    const key = el.getAttribute('data-i18n-value')
    el.value = __(key)
  })
}

/**
 * Update the locale toggle button text.
 */
function updateLocaleButton() {
  const btns = ['locale-toggle', 'locale-toggle-mobile']
  btns.forEach(id => {
    const btn = document.getElementById(id)
    if (btn) btn.textContent = currentLocale === 'en' ? 'KH' : 'EN'
  })
}

// ──────────────────────────────────────
// Theme
// ──────────────────────────────────────

/**
 * Apply the current theme.
 */
function applyTheme() {
  const isDark = document.documentElement.classList.contains('dark')
  const icon = document.getElementById('theme-icon')
  const mobileIcon = document.getElementById('theme-icon-mobile')
  const sunPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>'
  const moonPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>'
  if (icon) {
    icon.innerHTML = isDark ? moonPath : sunPath
  }
  if (mobileIcon) {
    mobileIcon.innerHTML = isDark ? moonPath : sunPath
  }
}

/**
 * Toggle dark mode.
 */
function toggleTheme() {
  const html = document.documentElement
  const isDark = html.classList.toggle('dark')
  localStorage.setItem('admin_theme', isDark ? 'dark' : 'light')
  applyTheme()
}

// ──────────────────────────────────────
// Init
// ──────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
  // Init locale
  const savedLocale = localStorage.getItem('admin_locale') || 'en'
  setLocale(savedLocale)

  // Init theme icon
  applyTheme()

  // Wire up theme toggle
  const themeBtn = document.getElementById('theme-toggle')
  if (themeBtn) themeBtn.addEventListener('click', toggleTheme)

  // Wire up locale toggle
  const localeBtn = document.getElementById('locale-toggle')
  if (localeBtn) localeBtn.addEventListener('click', () => {
    setLocale(currentLocale === 'en' ? 'km' : 'en')
  })
})

// Export for use in inline scripts if needed
window.__ = __
window.toggleTheme = toggleTheme
window.setLocale = setLocale
