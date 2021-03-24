import '@yaireo/tagify/dist/tagify.css'

import TagInputManager from './scripts/TagInputManager'
import './styles/app.scss'

const tagInputManager = new TagInputManager()

tagInputManager.init()

class GameRow {
  /**
   * @private
   */
  _tr
  name
  tags

  constructor(tr) {
    this._tr = tr
    this.tags = JSON.parse(tr.getAttribute('tags'))
    this.name = tr.getAttribute('game')
  }

  hide() {
    this._tr.style.display = 'none'
  }

  show() {
    this._tr.style.display = null
  }
}

class Filters {
  _filters = {
    selectedTags: [],
    gameName: ''
  }

  /**
   * @private
   * @type {GameRow[]}
   */
  _gameRows

  constructor(gameRows) {
    this._gameRows = gameRows
  }

  setSelectedTags(selectedTags) {
    this._filters.selectedTags = selectedTags

    this.filter()
  }

  setGameName(name) {
    this._filters.gameName = name

    this.filter()
  }

  filter() {
    this._gameRows.forEach(gameRow => {
      if (-1 === gameRow.name.toLowerCase().indexOf(this._filters.gameName.toLowerCase())) {
        return gameRow.hide()
      }

      if (this._filters.selectedTags.length > 0 && !gameRow.tags.filter(value => this._filters.selectedTags.includes(value)).length > 0) {
        return gameRow.hide()
      }

      return gameRow.show()
    })
  }
}

const allGamesTable = document.getElementById('all_games')

if (allGamesTable) {
  const rows = [...allGamesTable.querySelectorAll('tbody tr')].map(tr => new GameRow(tr))
  const gameInput = document.getElementById('filter_games_game')
  const filters = new Filters(rows)

  tagInputManager
    .get('filter_games_tags')
    .on('change', event => filters.setSelectedTags(event.detail.tagify.value.map(tag => parseInt(tag.id, 10))))

  gameInput.addEventListener('keyup', event => filters.setGameName(event.target.value))
  gameInput.addEventListener('blur', event => filters.setGameName(event.target.value))
}
