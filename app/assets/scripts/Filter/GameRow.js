export default class GameRow {
  /**  @private  */
  _tr
  name
  tags
  users

  constructor(tr) {
    this._tr = tr
    this.tags = JSON.parse(tr.getAttribute('tags'))
    this.name = tr.getAttribute('game')
    this.users = [...tr.querySelectorAll('td[user]')]
      .filter(td => 'true' === td.getAttribute('has'))
      .map(td => parseInt(td.getAttribute('user'), 10))
  }

  hide() {
    this._tr.style.display = 'none'
  }

  show() {
    this._tr.style.display = null
  }
}
