let settings = {};

settings.opening            =
`wp.blocks.registerBlockType(
  'namespace/block-name',
  {
`;
settings.titleComment       =
`    // Localize title using wp.i18n.__()\n`;
settings.title              =
`    title: __( 'Block Demo', 'textdomain' ),\n`;
settings.categoryComment    =
`    // Category Options: common, formatting, layout, widgets, embed\n`;
settings.category           =
`    category: 'common',\n`;
settings.iconComment        =
`    // Dashicons Options - https://goo.gl/aTM1DQ\n`;
settings.icon               =
`    icon: 'wordpress-alt',\n`;
settings.iconAltComment     =
`    // Custom SVG Icon\n`;
settings.iconAlt            =
`    icon: <svg width="20" height="20"><circle cx="10" cy="10" r="8" stroke="black" strokeWidth="2" fill="white" /></svg>,\n`;
settings.keywordsComment    =
`    // Limit to 3 Keywords / Phrases\n`;
settings.keywords           =
`    keywords: [
      __( 'Example', 'textdomain' ),
      __( 'Project', 'textdomain' ),
      __( 'Code Samples', 'textdomain' )
    ],\n`;
settings.supportsComment    =
`    // Enable or disable support for features\n`;
settings.supports           =
`    supports: {
        html: false
    },\n`;
settings.attributesComment  =
`    // Attributes set for each piece of dynamic data used in your block\n`;
settings.attributes         =
`    attributes: {
      content: {
        type: 'array',
        source: 'children',
        selector: 'div.my-content',
      },
    },\n`;
settings.editComment        =
`    // Determines what is displayed in the editor\n`;
settings.edit               =
`    edit: props => {
      const onChangeContent = value => {
        props.setAttributes( { content: value } );
      };
      return (
        <div className={ props.className }>
          <RichText
            tagname="div"
            multiline="p"
            className="my-content"
            placeholder={ __( 'Add your content...', 'textdomain' ) }
            value={ props.attributes.content }
            onChange={ onChangeContent }
          />
        </div>
      );
    },\n`;
settings.saveComment        =
`    // Determines what is displayed on the frontend\n`;
settings.save               =
`    save: props => {
      return (
        <div className={ props.className }>
          <div class="my-content">
            { props.attributes.content }
          </div>
        </div>
      );
    },\n`;
settings.closing            =
`  },
);`;

export default settings;
