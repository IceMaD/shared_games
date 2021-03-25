import './styles/app.scss'
import {tagInputManager} from './scripts/TagInputManager'

let route = document.querySelector('body').getAttribute('route')
let scriptMap = {
  home: 'Home',
  tags: 'Tags'
}

tagInputManager.init()

if (scriptMap[route]) {
  import(`./scripts/Page/${scriptMap[route]}`)
}
