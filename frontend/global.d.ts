// arquivo criado para permitir a importação de arquivos CSS Modules
// sem erros de tipo, como no caso do styles.module.css

declare module "*.module.css" {
  const classes: { [key: string]: string };
  export default classes;
}