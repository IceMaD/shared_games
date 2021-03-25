import './styles/app.scss'

let route = document.querySelector('body').getAttribute('route')
let scriptMap = {
  home: 'Home',
  tags: 'Tags'
}

if (scriptMap[route]) {
  import(`./scripts/Page/${scriptMap[route]}`)
}
