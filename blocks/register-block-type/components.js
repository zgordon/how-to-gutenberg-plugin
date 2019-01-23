const { Fragment } = wp.element;
import settings from "./code-snippets.js";

export function TitleDescription() {
  return (
    <Fragment>
      <em>{settings.titleComment}</em>
      {settings.title}
    </Fragment>
  );
}

export function Category() {
  return (
    <Fragment>
      <em>{settings.categoryComment}</em>
      {settings.category}
    </Fragment>
  );
}

export function Icon() {
  return (
    <Fragment>
      <em>{settings.iconComment}</em>
      {settings.icon}
    </Fragment>
  );
}

export function Keywords() {
  return (
    <Fragment>
      <em>{settings.keywordsComment}</em>
      {settings.keywords}
    </Fragment>
  );
}

export function Supports() {
  return (
    <Fragment>
      <em>{settings.supportsComment}</em>
      {settings.supports}
    </Fragment>
  );
}

export function Attributes() {
  return (
    <Fragment>
      <em>{settings.attributesComment}</em>
      {settings.attributes}
    </Fragment>
  );
}

export function Edit() {
  return (
    <Fragment>
      <em>{settings.editComment}</em>
      {settings.edit}
    </Fragment>
  );
}

export function Save() {
  return (
    <Fragment>
      <em>{settings.saveComment}</em>
      {settings.save}
    </Fragment>
  );
}
