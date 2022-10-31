export default [
  {
    header: 'Dashboard',
    icon: 'HomeIcon',
    children: [
      {
        title: 'Analytics',
        route: 'dashboard-analytics',
        icon: 'ActivityIcon',
      },
    ],
  },
  {
    header: 'My Account',
    icon: 'SettingsIcon',
    children: [
      {
        title: 'Update Password',
        route: 'update-password',
        icon: 'LockIcon',
      },
      {
        title: 'Update Email Address',
        route: 'update-email-address',
        icon: 'MailIcon',
      },
      {
        title: 'Update Profile',
        route: 'update-profile',
        icon: 'UserIcon',
      },
      {
        title: 'Apps',
        route: 'apps',
        icon: 'PackageIcon',
      },
      {
        title: 'Logs',
        route: 'logs',
        icon: 'AlertCircleIcon',
      },
    ],
  },
  {
    header: 'Manage Users',
    icon: 'UserIcon',
    children: [
      {
        title: 'User Accounts',
        route: 'user-accounts',
        icon: 'UserIcon',
      },
      // {
      //   title: 'User Imports',
      //   route: 'user-imports',
      //   icon: 'UserIcon',
      // },
      // {
      //   title: 'User Groups',
      //   route: 'user-groups',
      //   icon: 'UserIcon',
      // },
      // {
      //   title: 'Custom User Fields',
      //   route: 'custom-user-fields',
      //   icon: 'UserIcon',
      // },
      // {
      //   title: 'User Logs',
      //   route: 'user-authentication-logs',
      //   icon: 'AlertCircleIcon',
      // },
    ],
  },
  // {
  //   header: 'Manage SSO',
  //   icon: 'FileIcon',
  //   children: [
  //     {
  //       title: 'Identity Provider',
  //       route: 'identity-providers',
  //       icon: 'FileIcon',
  //     },
  //     {
  //       title: 'Service Providers',
  //       route: 'service-providers',
  //       icon: 'FileIcon',
  //     },
  //     {
  //       title: 'Federations',
  //       route: 'federations',
  //       icon: 'SearchIcon',
  //     },
  //     {
  //       title: 'App Links',
  //       route: 'app-links',
  //       icon: 'PackageIcon',
  //     },
  //     {
  //       title: 'App Co-brandings',
  //       route: 'app-co-brandings',
  //       icon: 'PackageIcon',
  //     },
  //     {
  //       title: 'SAML Transaction Logs',
  //       route: 'saml-transactions-logs',
  //       icon: 'AlertCircleIcon',
  //     },
  //   ],
  // },
  // {
  //   header: 'Contact Us',
  //   icon: 'MailIcon',
  //   children: [
  //     {
  //       title: 'Contact Now',
  //       route: 'contact-us',
  //       icon: 'MailIcon',
  //     },
  //   ]
  // },
]
