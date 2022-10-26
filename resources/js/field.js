import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-nova4-multicolumn', IndexField)
  app.component('detail-nova4-multicolumn', DetailField)
  app.component('form-nova4-multicolumn', FormField)
})
