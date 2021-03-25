import {createPopper} from '@popperjs/core'
import 'unicode-emoji-picker'

export default class PickerManager {
  static append = (element, pick) => {
    const picker = document.createElement('unicode-emoji-picker')
    picker.setAttribute('default-group', 'search')
    const body = document.querySelector('body')

    body.appendChild(picker)

    const popper = createPopper(element, picker, {
      placement: 'bottom-start',
      modifiers: [
        {
          name: 'offset',
          options: {
            offset: [0, 5]
          }
        }
      ]
    })

    picker.addEventListener('emoji-pick', event => pick(event.detail.emoji))

    body.addEventListener('click', function onBlur(event) {
      if (element.contains(event.target) || picker.contains(event.target)) {
        return
      }

      body.removeChild(picker)
      popper.destroy()
      body.removeEventListener('click', onBlur)
    })
  }
}
