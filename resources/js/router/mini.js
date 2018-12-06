import MiniSidebarLayout from '../container/MiniSidebarLayout'

// dashboard components
import Ecommerce from '../views/dashboard/Ecommerce';
import WebAnalytics from '../views/dashboard/WebAnalytics';
import Magazine from '../views/dashboard/Magazine';
import News from '../views/dashboard/News';
import Agency from '../views/dashboard/Agency';
import Saas from '../views/dashboard/Saas';

// Widgets component
import ChartWidgets from '../views/widgets/chart-widgets/ChartWidgets';
import UserWidgets from '../views/widgets/user-widgets/UserWidgets';

//Ecommerce Widgets
import Shop from '../views/ecommerce/Shop';
import Cart from '../views/ecommerce/Cart';
import Checkout from '../views/ecommerce/Checkout';
import CreditCard from '../views/ecommerce/CreditCard';

// Inbox component
import Inbox from '../views/inbox/Inbox';

// chat component
import Chat from '../views/chat/Chat';

// calendar components
import Calendar from '../views/calendar/Calendar';

// ui components
import Buttons from '../views/ui-elements/Buttons';
import Cards from '../views/ui-elements/Cards';
import Grid from '../views/ui-elements/Grid';
import List from '../views/ui-elements/List';
import Menu from '../views/ui-elements/Menu';
import Slider from '../views/ui-elements/Slider';
import Snackbar from '../views/ui-elements/Snackbar';
import Tooltip from '../views/ui-elements/Tooltip';
import Dialog from '../views/ui-elements/Dialog';
import Select from '../views/ui-elements/Select';
import Input from '../views/ui-elements/Input';
import Checkbox from '../views/ui-elements/Checkbox';
import Radio from '../views/ui-elements/Radio';
import Toolbar from '../views/ui-elements/Toolbar';
import Progress from '../views/ui-elements/Progress';
import Tabs from '../views/ui-elements/Tabs';
import Carousel from '../views/ui-elements/Carousel';
import Chips from '../views/ui-elements/Chips';
import Datepicker from '../views/ui-elements/Datepicker';
import Timepicker from '../views/ui-elements/Timepicker';

// chart components
import VueChartjs from '../views/charts/VueChartjs';
import VueEcharts from '../views/charts/VueEcharts';

// maps views
import GoogleMaps from '../views/maps/GoogleMaps';
import LeafletMaps from '../views/maps/LeafletMaps';
import JvectorMap from '../views/maps/JvectorMap';

// Pages views
import Blank from '../views/pages/Blank';
import Blog from '../views/pages/Blog';
import Gallery from '../views/pages/Gallery';
import Pricing1 from '../views/pages/Pricing-1';
import Pricing2 from '../views/pages/Pricing-2';

// users views
import UserProfile from '../views/users/UserProfile';
import UsersList from '../views/users/UsersList';

// drag-drop components
import Vue2Dragula from '../views/drag-drop/Vue2Dragula';
import VueDraggable from '../views/drag-drop/Vuedraggable';
import VueDraggableResizeable from '../views/drag-drop/VueDraggableResizable';

// icons components
import Themify from '../views/icons/Themify';
import Material from '../views/icons/Material';

// editor components
import QuillEditor from '../views/editor/QuillEditor';
import WYSIWYG from '../views/editor/WYSIWYG';

// form componenets
import FormValidation from '../views/forms/FormValidation';
import Stepper from '../views/forms/Stepper';

// Data table componenets
import Standard from '../views/tables/Standard';
import Slots from '../views/tables/Slots';
import SelectableRows from '../views/tables/SelectableRows';
import SearchWithText from '../views/tables/SearchWithText';

// Extensions components
import ImageCropper from '../views/extensions/ImageCropper';
import VideoPlayer from '../views/extensions/VideoPlayer';
import Dropzone from '../views/extensions/Dropzone';

export default {
   path: '/mini',
   component: MiniSidebarLayout,
   redirect: '/mini/dashboard/ecommerce',
   children: [
      {
         component: Ecommerce,
         path: '/mini/dashboard/ecommerce',
         meta: {
            requiresAuth: true,
            title: 'message.ecommerce',
            breadcrumb: 'Dashboard / Ecommerce'
         }
      },
      {
         component: WebAnalytics,
         path: '/mini/dashboard/web-analytics',
         meta: {
            requiresAuth: true,
            title: 'message.webAnalytics',
            breadcrumb: 'Dashboard / Web Analytics'
         }
      },
      {
         component: Magazine,
         path: '/mini/dashboard/magazine',
         meta: {
            requiresAuth: true,
            title: 'message.magazine',
            breadcrumb: 'Dashboard / Magazine'
         }
      },
      {
         component: News,
         path: '/mini/dashboard/news',
         meta: {
            requiresAuth: true,
            title: 'message.news',
            breadcrumb: 'Dashboard / News'
         }
      },
      {
         component: Agency,
         path: '/mini/dashboard/agency',
         meta: {
            requiresAuth: true,
            title: 'message.agency',
            breadcrumb: 'Dashboard / Agency'
         }
      },
      {
         component: Saas,
         path: '/mini/dashboard/saas',
         meta: {
            requiresAuth: true,
            title: 'message.saas',
            breadcrumb: 'Dashboard / SAAS'
         }
      },
      {
         path: '/mini/widgets/user-widgets',
         component: UserWidgets,
         meta: {
            requiresAuth: true,
            title: 'message.user',
            breadcrumb: 'Widgets / User'
         }
      },
      {
         path: '/mini/widgets/chart-widgets',
         component: ChartWidgets,
         meta: {
            requiresAuth: true,
            title: 'message.charts',
            breadcrumb: 'Widgets / Charts'
         }
      },
      {
         path: '/mini/ecommerce/shop',
         component: Shop,
         meta: {
            requiresAuth: true,
            title: 'message.shop',
            breadcrumb: 'Ecommerce / Shop'
         }
      },
      {
         path: '/mini/ecommerce/cart',
         component: Cart,
         meta: {
            requiresAuth: true,
            title: 'message.cart',
            breadcrumb: 'Ecommerce / Cart'
         }
      },
      {
         path: '/mini/ecommerce/checkout',
         component: Checkout,
         meta: {
            requiresAuth: true,
            title: 'message.checkout',
            breadcrumb: 'Ecommerce / Checkout'
         }
      },
      {
         path: '/mini/ecommerce/cards',
         component: CreditCard,
         meta: {
            requiresAuth: true,
            title: 'message.cards',
            breadcrumb: 'Ecommerce / Cards'
         }
      },
      {
         path: '/mini/pages/blog',
         component: Blog,
         meta: {
            requiresAuth: true,
            title: 'message.blog',
            breadcrumb: 'Pages / Blog'
         }
      },
      {
         component: Gallery,
         path: '/mini/pages/gallery',
         meta: {
            requiresAuth: true,
            title: 'message.gallery',
            breadcrumb: 'Pages / Gallery'
         }
      },
      {
         component: Pricing1,
         path: '/mini/pages/pricing-1',
         meta: {
            requiresAuth: true,
            title: 'message.pricing1',
            breadcrumb: 'Pages / Pricing-1'
         }
      },
      {
         component: Pricing2,
         path: '/mini/pages/pricing-2',
         meta: {
            requiresAuth: true,
            title: 'message.pricing2',
            breadcrumb: 'Pages / Pricing-2'
         }
      },
      {
         component: Blank,
         path: '/mini/pages/blank',
         meta: {
            requiresAuth: true,
            title: 'message.blank',
            breadcrumb: 'Pages / Blank'
         }
      },
      {
         component: Inbox,
         path: '/mini/inbox',
         meta: {
            requiresAuth: true,
            title: 'message.inbox',
            breadcrumb: 'Modules / Inbox'
         }
      },
      {
         component: Chat,
         path: '/mini/chat',
         meta: {
            requiresAuth: true,
            title: 'message.chat',
            breadcrumb: 'Modules / Chat'
         }
      },
      {
         component: Buttons,
         path: '/mini/ui-elements/buttons',
         meta: {
            requiresAuth: true,
            title: 'message.buttons',
            breadcrumb: 'UI Elements / Button'
         }
      },
      {
         component: Cards,
         path: '/mini/ui-elements/cards',
         meta: {
            requiresAuth: true,
            title: 'message.cards',
            breadcrumb: 'UI Elements / Cards'
         }
      },
      {
         component: Checkbox,
         path: '/mini/ui-elements/checkbox',
         meta: {
            requiresAuth: true,
            title: 'message.checkbox',
            breadcrumb: 'UI Elements / Checkbox'
         }
      },
      {
         component: Carousel,
         path: '/mini/ui-elements/carousel',
         meta: {
            requiresAuth: true,
            title: 'message.carousel',
            breadcrumb: 'UI Elements / Carousel'
         }
      },
      {
         component: Chips,
         path: '/mini/ui-elements/chips',
         meta: {
            requiresAuth: true,
            title: 'message.chips',
            breadcrumb: 'UI Elements / Chips'
         }
      },
      {
         component: Datepicker,
         path: '/mini/ui-elements/datepicker',
         meta: {
            requiresAuth: true,
            title: 'message.datepicker',
            breadcrumb: 'UI Elements / Datepicker'
         }
      },
      {
         component: Dialog,
         path: '/mini/ui-elements/dialog',
         meta: {
            requiresAuth: true,
            title: 'message.dialog',
            breadcrumb: 'UI Elements / Dialog'
         }
      },
      {
         component: Grid,
         path: '/mini/ui-elements/grid',
         meta: {
            requiresAuth: true,
            title: 'message.grid',
            breadcrumb: 'UI Elements / Grid'
         }
      },
      {
         component: Input,
         path: '/mini/ui-elements/input',
         meta: {
            requiresAuth: true,
            title: 'message.input',
            breadcrumb: 'UI Elements / Input'
         }
      },
      {
         component: List,
         path: '/mini/ui-elements/list',
         meta: {
            requiresAuth: true,
            title: 'message.list',
            breadcrumb: 'UI Elements / List'
         }
      },
      {
         component: Menu,
         path: '/mini/ui-elements/menu',
         meta: {
            requiresAuth: true,
            title: 'message.menu',
            breadcrumb: 'UI Elements / Menu'
         }
      },
      {
         component: Progress,
         path: '/mini/ui-elements/progress',
         meta: {
            requiresAuth: true,
            title: 'message.progress',
            breadcrumb: 'UI Elements / Progress'
         }
      },
      {
         component: Radio,
         path: '/mini/ui-elements/radio',
         meta: {
            requiresAuth: true,
            title: 'message.radio',
            breadcrumb: 'UI Elements / Radio'
         }
      },
      {
         component: Select,
         path: '/mini/ui-elements/select',
         meta: {
            requiresAuth: true,
            title: 'message.select',
            breadcrumb: 'UI Elements / Select'
         }
      },
      {
         component: Slider,
         path: '/mini/ui-elements/slider',
         meta: {
            requiresAuth: true,
            title: 'message.slider',
            breadcrumb: 'UI Elements / Slider'
         }
      },
      {
         component: Snackbar,
         path: '/mini/ui-elements/snackbar',
         meta: {
            requiresAuth: true,
            title: 'message.snackbar',
            breadcrumb: 'UI Elements / Snackbar'
         }
      },
      {
         component: Tabs,
         path: '/mini/ui-elements/tabs',
         meta: {
            requiresAuth: true,
            title: 'message.tabs',
            breadcrumb: 'UI Elements / Tabs'
         }
      },
      {
         component: Toolbar,
         path: '/mini/ui-elements/toolbar',
         meta: {
            requiresAuth: true,
            title: 'message.toolbar',
            breadcrumb: 'UI Elements / Toolbar'
         }
      },
      {
         component: Tooltip,
         path: '/mini/ui-elements/tooltip',
         meta: {
            requiresAuth: true,
            title: 'message.tooltip',
            breadcrumb: 'UI Elements / Tooltip'
         }
      },
      {
         component: Timepicker,
         path: '/mini/ui-elements/timepicker',
         meta: {
            requiresAuth: true,
            title: 'message.timepicker',
            breadcrumb: 'UI Elements / Timepicker'
         }
      },
      {
         component: FormValidation,
         path: '/mini/forms/form-validation',
         meta: {
            requiresAuth: true,
            title: 'message.formValidation',
            breadcrumb: 'Forms / FormValidation'
         }
      },
      {
         component: Stepper,
         path: '/mini/forms/stepper',
         meta: {
            requiresAuth: true,
            title: 'message.stepper',
            breadcrumb: 'Forms / Stepper'
         }
      },
      {
         component: VueChartjs,
         path: '/mini/charts/vue-chartjs',
         meta: {
            requiresAuth: true,
            title: 'message.vueChartjs',
            breadcrumb: 'Charts / Vue Chartjs'
         }
      },
      {
         component: VueEcharts,
         path: '/mini/charts/vue-echarts',
         meta: {
            requiresAuth: true,
            title: 'message.vueEcharts',
            breadcrumb: 'Charts / Vue Echarts'
         }
      },
      {
         component: Themify,
         path: '/mini/icons/themify',
         meta: {
            requiresAuth: true,
            title: 'message.themify',
            breadcrumb: 'Icons / Themify'
         }
      },
      {
         component: Material,
         path: '/mini/icons/material',
         meta: {
            requiresAuth: true,
            title: 'message.material',
            breadcrumb: 'Icons / Material'
         }
      },
      {
         component: Standard,
         path: '/mini/tables/standard',
         meta: {
            requiresAuth: true,
            title: 'message.standard',
            breadcrumb: 'Tables / Standard'
         }
      },
      {
         component: Slots,
         path: '/mini/tables/slots',
         meta: {
            requiresAuth: true,
            title: 'message.slots',
            breadcrumb: 'Tables / Slots'
         }
      },
      {
         component: SelectableRows,
         path: '/mini/tables/selectablerows',
         meta: {
            requiresAuth: true,
            title: 'message.selectable',
            breadcrumb: 'Tables / Selectable Rows'
         }
      },
      {
         component: SearchWithText,
         path: '/mini/tables/searchwithtext',
         meta: {
            requiresAuth: true,
            title: 'message.searchRow',
            breadcrumb: 'Tables / Search Row'
         }
      },
      {
         component: GoogleMaps,
         path: '/mini/maps/google-maps',
         meta: {
            requiresAuth: true,
            title: 'message.googleMaps',
            breadcrumb: 'Maps / Google Maps'
         }
      },
      {
         component: LeafletMaps,
         path: '/mini/maps/leaflet-maps',
         meta: {
            requiresAuth: true,
            title: 'message.leafletMaps',
            breadcrumb: 'Maps / Leaflet Maps'
         }
      },
      {
         component: JvectorMap,
         path: '/mini/maps/jvector-map',
         meta: {
            requiresAuth: true,
            title: 'message.jvectorMap',
            breadcrumb: 'Maps / JVector Map'
         }
      },
      {
         component: UserProfile,
         path: '/mini/users/user-profile',
         meta: {
            requiresAuth: true,
            title: 'message.userProfile',
            breadcrumb: 'Users / User Profile'
         }
      },
      {
         component: UsersList,
         path: '/mini/users/users-list',
         meta: {
            requiresAuth: true,
            title: 'message.usersList',
            breadcrumb: 'Users / Users List'
         }
      },
      {
         component: Calendar,
         path: '/mini/calendar',
         meta: {
            requiresAuth: true,
            title: 'message.calendar',
            breadcrumb: 'Calendar'
         }
      },
      {
         component: QuillEditor,
         path: '/mini/editor/quilleditor',
         meta: {
            requiresAuth: true,
            title: 'message.quillEditor',
            breadcrumb: 'Editor / Quill Editor'
         }
      },
      {
         component: WYSIWYG,
         path: '/mini/editor/wysiwyg',
         meta: {
            requiresAuth: true,
            title: 'message.wYSIWYG',
            breadcrumb: 'Editor / WYSIWYG'
         }
      },
      {
         component: Vue2Dragula,
         path: '/mini/drag-drop/vue2dragula',
         meta: {
            requiresAuth: true,
            title: 'message.vue2Dragula',
            breadcrumb: 'Drag And Drop / Vue2 Dragula'
         }
      },
      {
         component: VueDraggable,
         path: '/mini/drag-drop/vuedraggable',
         meta: {
            requiresAuth: true,
            title: 'message.vueDraggable',
            breadcrumb: 'Drag And Drop / Vue Draggable'
         }
      },
      {
         component: VueDraggableResizeable,
         path: '/mini/drag-drop/vuedraggableresizeable',
         meta: {
            requiresAuth: true,
            title: 'message.draggableResizeable',
            breadcrumb: 'Drag And Drop / Draggable Resizeable'
         }
      },
      {
         path: '/mini/image-cropper',
         component: ImageCropper,
         meta: {
            requiresAuth: true,
            title: 'message.imageCropper',
            breadcrumb: 'Extensions / Image Cropper'
         }
      },
      {
         path: '/mini/video-player',
         component: VideoPlayer,
         meta: {
            requiresAuth: true,
            title: 'message.videoPlayer',
            breadcrumb: 'Extensions / Video Player'
         }
      },
      {
         path: '/mini/dropzone',
         component: Dropzone,
         meta: {
            requiresAuth: true,
            title: 'message.dropzone',
            breadcrumb: 'Extensions / Dropzone'
         }
      }
   ]
}
