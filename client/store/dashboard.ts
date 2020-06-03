import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

@Module({
  stateFactory: true,
})
export default class DashboardModule extends VuexModule {
  private sidebar = {
    isVisible: true,
  };

  private navbar = {
    breadcrumb: [],
  };

  @Mutation
  public setVisibleSidebar(visible: boolean) {
    this.sidebar.isVisible = visible;
  }

  @Mutation
  public setBreadcrumb(breadcrumb: any) {
    this.navbar.breadcrumb = breadcrumb;
  }
}
