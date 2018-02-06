import * as React from 'react';
import Locale from 'pimfront/app/domain/model/locale';
import Flag from 'pimfront/app/application/component/flag';
import Dropdown, {DropdownElement} from 'pimfront/app/application/component/dropdown';
import * as trans from 'pimenrich/lib/translator';

const LocaleItemView = ({
  element,
  isActive,
  onClick,
}: {
  element: DropdownElement;
  isActive: boolean;
  onClick: (element: DropdownElement) => void;
}): JSX.Element => {
  const menuLinkClass = `AknDropdown-menuLink ${isActive ? `AknDropdown-menuLink--active` : ''}`;

  return (
    <div className={menuLinkClass} data-locale={element.identifier} onClick={() => onClick(element)}>
      <span className="label">
        <Flag locale={element.original} displayLanguage />
      </span>
    </div>
  );
};

const LocaleButtonView = ({
  label,
  selectedElement,
  onClick,
}: {
  label: string;
  selectedElement: DropdownElement;
  onClick: () => void;
}) => (
  <div className="AknActionButton AknActionButton--withoutBorder" onClick={onClick}>
    <div className="AknColumn-subtitle">{trans.get('Locale')}</div>
    <div className="AknColumn-value value">
      <Flag locale={selectedElement.original} displayLanguage />
    </div>
  </div>
);

export default ({
  localeCode,
  locales,
  onLocaleChange,
}: {
  localeCode: string;
  locales: Locale[];
  onLocaleChange: (locale: Locale) => void;
}) => {
  return (
    <Dropdown
      elements={locales.map((locale: Locale) => {
        return {
          identifier: locale.code,
          label: locale.label,
          original: locale,
        };
      })}
      label={trans.get('Locale')}
      selectedElement={localeCode}
      ItemView={LocaleItemView}
      ButtonView={LocaleButtonView}
      onSelectionChange={(selection: string) => {
        const locale = locales.find((locale: Locale) => locale.code === selection);

        if (undefined !== locale) {
          onLocaleChange(locale);
        }
      }}
    />
  );
};
