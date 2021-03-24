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

class Filters {
  _filters = {
    selectedTags: [],
    userIds: [],
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

  toggleUser(userId) {
    if (this.hasUser(userId)) {
      this._filters.userIds = this._filters.userIds.filter(id => id !== userId)
    } else {
      this._filters.userIds = [...this._filters.userIds, userId]
    }

    this.filter()
  }

  hasUser(userId) {
    return this._filters.userIds.includes(userId)
  }

  filter() {
    this._gameRows.forEach(gameRow => {
      if (!gameRow.name.toLowerCase().includes(this._filters.gameName.toLowerCase())) {
        return gameRow.hide()
      }

      if (0 < this._filters.selectedTags.length && 0 === gameRow.tags.filter(value => this._filters.selectedTags.includes(value)).length) {
        return gameRow.hide()
      }

      if (0 < this._filters.userIds.length && 0 === gameRow.users.filter(value => this._filters.userIds.includes(value)).length) {
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

  allGamesTable.querySelectorAll('thead td[user]').forEach(td => {
    const userId = parseInt(td.getAttribute('user'), 10)

    td.addEventListener('click', () => {
      filters.toggleUser(userId)

      if (filters.hasUser(userId)) {
        td.classList.add('selected')
      } else {
        td.classList.remove('selected')
      }
    })
  })
}
